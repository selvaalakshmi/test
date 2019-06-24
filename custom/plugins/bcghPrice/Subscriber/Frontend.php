<?php
namespace bcghPrice\Subscriber;

use Enlight\Event\SubscriberInterface;

class Frontend implements SubscriberInterface
{
    /**
     * To set event
     * 
     * @return array
     */ 
    public static function getSubscribedEvents()
    {
        return ['Enlight_Controller_Action_PreDispatch_Frontend' => 'onPostDispatchAccount',
                'Enlight_Controller_Action_PostDispatch_Frontend' => 'onPostDispatchAccount',
                'Enlight_Controller_Action_PostDispatchSecure_Widgets_Emotion' => 'onPostDispatchEmotion',
                ];
    }

    /**
     * Extends account order detail template.
     *
     * @param Enlight_Event_EventArgs $args
     * 
     * @return null
     */
    public static function onPostDispatchAccount(\Enlight_Event_EventArgs $args)
    {
        $request  = $args->getSubject()->Request();
        $response = $args->getSubject()->Response();
        $view     = $args->getSubject()->View();
        if (!$request->isDispatched() || $response->isException() || $request->getModuleName() !== 'frontend') {
            return null;
        }
        //For extend the Novalnet template from core template
        if (in_array($request->getControllerName(),array('index','detail','checkout','listing')) && in_array($request->getActionName(),array('index','cart'))) {
            $view->addTemplateDir(dirname(__DIR__) . '/Resources/views/');
        }
    }

    /**
     * add new template and override the template files
     * 
     * @param \Enlight_Event_EventArgs $args
     * 
     * @return null
     */
    public function onPostDispatchEmotion(\Enlight_Event_EventArgs $args)
    {
        $request  = $args->getSubject()->Request();
        $view     = $args->getSubject()->View();
        if (in_array($request->getControllerName(),array('index','emotion')) && in_array($request->getActionName(),array('index'))) {
            $view->addTemplateDir(dirname(__DIR__) . '/Resources/views/');
        }
    }
}

