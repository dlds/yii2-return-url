<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2015 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\returnurl;

use Yii;
use yii\base\ActionFilter;

/**
 * ReturnUrl filter
 * 
 * Keep current URL (if it's not an AJAX url) in session so that the browser may be redirected back.
 */
class ReturnUrl extends ActionFilter {

    /**
     * This method is invoked right before an action is to be executed (after all possible filters.)
     * You may override this method to do last-minute preparation for the action.
     * @param Action $action the action to be executed.
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {
        if (!Yii::$app->request->getIsAjax())
        {
            Yii::$app->user->setReturnUrl(Yii::$app->request->getUrl());
        }

        return true;
    }
}