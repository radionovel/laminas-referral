<?php

namespace Radionovel\LaminasReferral\Service;

use Laminas\Http\PhpEnvironment\Request;

class ReferralService
{
    const TTL = 1;
    const REFERRAL_VARIABLE = 'referrer_id';
    /**
     * @var array
     */
    private $config;
    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $referralCodeName;
    /**
     * @var int
     */
    private $liveTime;

    /**
     * ReferralService constructor.
     *
     * @param Request $request
     * @param $config
     */
    public function __construct(Request $request, $config)
    {
        $this->initialConfig($config);
        $this->request = $request;
        $referral_code = $this->extractReferralCodeFromRequest();
        if (!empty($referral_code)) {
            $this->storeReferralCode($referral_code);
        }
    }

    /**
     * @param $config
     */
    public function initialConfig($config)
    {
        $this->config = $config;
        if (empty($this->config['ttl'])) {
            $this->liveTime = static::TTL;
        } else {
            $this->setLiveTime($this->config['ttl']);
        }

        if (empty($this->config['request_variable'])) {
            $this->referralCodeName = static::REFERRAL_VARIABLE;
        } else {
            $this->referralCodeName = $this->config['request_variable'];
        }
    }

    /**
     * @return string|null
     */
    protected function extractReferralCodeFromRequest()
    {
        $referral_code = "";
        if ($this->request->isPost()) {
            $referral_code = $this->request->getPost($this->referralCodeName, null);
        }
        if ($this->request->isGet()) {
            $referral_code = $this->request->getQuery($this->referralCodeName, null);
        }

        return $referral_code;
    }

    /**
     * @return string
     */
    public function getReferralCode()
    {
         return $this->getCodeFromCookie() ? $this->extractReferralCodeFromRequest() : "";
    }

    /**
     * @return string
     */
    private function getCodeFromCookie()
    {
        $cookies = $this->request->getHeaders()->get('cookie');

        return isset($cookies[$this->referralCodeName]) ? $cookies[$this->referralCodeName] : '';
    }

    /**
     * @param string|null $referral_code
     */
    private function storeReferralCode(?string $referral_code)
    {
        setcookie($this->referralCodeName, $referral_code, $this->getReferrerCodeTtl(), '/');
    }

    /**
     * @return float|int
     */
    private function getReferrerCodeTtl()
    {
        $days = $this->getLiveTime();

        return time() + 60 * 60 * 24 * $days;
    }

    private function getLiveTime()
    {
        return $this->liveTime;
    }

    private function setLiveTime($ttl)
    {
        $this->liveTime = (int) $ttl;
    }
}
