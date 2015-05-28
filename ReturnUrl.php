<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2015 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\returnurl;

use yii\base\ActionFilter;

/**
 * ReturnUrl filter
 * 
 * Keep current URL (if it's not an AJAX url) in session so that the browser may be redirected back.
 */
class ReturnUrl extends ActionFilter {

    /**
     * @var boolean indicates if absolute urls will be kept
     */
    public $keepAbsolute = false;

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        if (!\Yii::$app->getRequest()->getIsAjax())
        {
            if ($this->keepAbsolute)
            {
                \Yii::$app->getUser()->setReturnUrl(\Yii::$app->getRequest()->getAbsoluteUrl());
            }
            else
            {
                \Yii::$app->getUser()->setReturnUrl(\Yii::$app->getUrlManager()->parseRequest(\Yii::$app->getRequest()));
            }
        }

        return true;
    }

    /**
     * Retrieves stored return url
     * @param mixed $default holds default url to be retrieved
     */
    public static function load($default = null, $clear = true)
    {
        if (\Yii::$app)
        {
            $previous = \Yii::$app->getUser()->getReturnUrl($default);

            if ($clear)
            {
                \Yii::$app->getSession()->remove(\Yii::$app->getUser()->returnUrlParam);
            }

            return $previous;
        }

        return false;
    }
}