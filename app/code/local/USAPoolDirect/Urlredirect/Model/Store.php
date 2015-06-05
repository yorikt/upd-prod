<?php
 
class USAPoolDirect_Urlredirect_Model_Store extends Mage_Core_Model_Store
{
 
    public function getBaseUrl($type=self::URL_TYPE_LINK, $secure=null)
    {
        $cacheKey = $type . '/' . (is_null($secure) ? 'null' : ($secure ? 'true' : 'false'));
        if (!isset($this->_baseUrlCache[$cacheKey])) {
            switch ($type) {
                case self::URL_TYPE_WEB:
                    $secure = is_null($secure) ? $this->isCurrentlySecure() : (bool)$secure;
                    $url = $this->getConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_url');
                    break;

                case self::URL_TYPE_LINK:
                    $secure = (bool) $secure;
                    $url = $this->getConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_link_url');
                    $url = $this->_updatePathUseRewrites($url);
                    $url = $this->_updatePathUseStoreView($url);
                    break;

                case self::URL_TYPE_DIRECT_LINK:
                    $secure = (bool) $secure;
                    $url = $this->getConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_link_url');
                    $url = $this->_updatePathUseRewrites($url);
                    break;

                case self::URL_TYPE_SKIN:
                case self::URL_TYPE_JS:
                    $secure = is_null($secure) ? $this->isCurrentlySecure() : (bool) $secure;
                    $url = $this->getConfig('web/' . ($secure ? 'secure' : 'unsecure') . '/base_' . $type . '_url');
                    break;

                case self::URL_TYPE_MEDIA:
                    $url = $this->_updateMediaPathUseRewrites($secure);
                    break;

                default:
                    throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid base url type'));
            }

            if (false !== strpos($url, '{{base_url}}')) {
                $baseUrl = Mage::getConfig()->substDistroServerVars('{{base_url}}');
                $url = str_replace('{{base_url}}', $baseUrl, $url);
            }

            $this->_baseUrlCache[$cacheKey] = rtrim($url, '/') . '/';
        }


	//#######################################
	$myurl = $this->_baseUrlCache[$cacheKey];
	$myhost = $_SERVER['HTTP_HOST'];

	$url = explode($myhost,$myurl);
	if(!empty($url) && isset($url[1])){
		return $url[1];
	}		
	//#######################################


        return $this->_baseUrlCache[$cacheKey];
    }
 
}
 
?>
