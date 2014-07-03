<?php

namespace Backend\Modules\Groups\Engine;

use Symfony\Component\Finder\Finder;
use Common\Classes;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;

/**
 * In this file we store all generic functions that we will be using in the groups module.
 *
 * @author Wouter Sioen <wouter@wijs.be>
 */
class Permissions extends BackendBaseActionEdit
{
    /**
     * @var array
     */
    protected $actionGroups = array();
    protected $actions = array();
    protected $modules;
    protected $widgets;
    protected $widgetInstances;

    /**
     * Bundle all actions that need to be bundled
     */
    protected function bundleActions()
    {
        foreach ($this->modules as $module) {
            // loop through actions and add all classnames
            foreach ($this->actions[$module['value']] as $key => $action) {
                $class = Classes::buildForAjax('Backend', $module['value'], $action['value']);
                if (!class_exists($class)) {
                    $class = Classes::buildForAction('Backend', $module['value'], $action['value']);
                }

                $reflection = new \ReflectionClass($class);

                // get the tag offset
                $offset = strpos($reflection->getDocComment(), ACTION_GROUP_TAG) + strlen(ACTION_GROUP_TAG);

                // no tag present? move on!
                if(!($offset - strlen(ACTION_GROUP_TAG))) continue;

                // get the group info
                $groupInfo = trim(substr($reflection->getDocComment(), $offset, (strpos($reflection->getDocComment(), '*', $offset) - $offset)));

                // get name and description
                $bits = explode("\t", $groupInfo);

                // delete empty values
                foreach($bits as $i => $bit) if(empty($bit)) unset($bits[$i]);

                // add group to actions
                $this->actions[$module['value']][$key]['group'] = $bits[0];

                // add group to array
                $this->actionGroups[$bits[0]] = end($bits);
            }
        }
    }

    /**
     * Get the widgets
     */
    protected function getWidgets()
    {
        $finder = new Finder();
        $finder->name('*.php')
            ->in(BACKEND_MODULES_PATH . '/*/Widgets');
        foreach ($finder->files() as $file) {
            $module = $file->getPathInfo()->getPathInfo()->getBasename();
            if (BackendAuthentication::isAllowedModule($module)) {
                $widgetName = $file->getBasename('.php');
                $className = Classes::buildForWidget('Backend', $module, $widgetName);

                if (class_exists($className)) {
                    // add to array
                    $this->widgetInstances[] = array(
                        'module' => $module,
                        'widget' => $widgetName,
                        'className' => $className
                    );

                    // create reflection class
                    $reflection = new \ReflectionClass($className);
                    $phpDoc = trim($reflection->getDocComment());
                    if ($phpDoc != '') {
                        $offset = strpos($reflection->getDocComment(), '*', 7);
                        $description = substr($reflection->getDocComment(), 0, $offset);
                        $description = str_replace('*', '', $description);
                        $description = trim(str_replace('/', '', $description));
                    } else {
                        $description = '';
                    }

                    // check if model file exists
                    $pathName = $file->getPathInfo()->getPathInfo()->getRealPath();

                    // add to array
                    $this->widgets[] = array(
                        'label' => \SpoonFilter::toCamelCase($widgetName),
                        'value' => $widgetName,
                        'description' => $description
                    );
                }
            }
        }
    }

    /**
     * Get the actions
     */
    protected function getActions()
    {
        $filter = array('Authentication', 'Error', 'Core');
        $modules = array();

        $finder = new Finder();
        $finder->name('*.php')
            ->in(BACKEND_MODULES_PATH . '/*/Actions')
            ->in(BACKEND_MODULES_PATH . '/*/Ajax');
        foreach ($finder->files() as $file) {
            $module = $file->getPathInfo()->getPathInfo()->getBasename();

            // skip some modules
            if (in_array($module, $filter)) {
                continue;
            }

            if (BackendAuthentication::isAllowedModule($module)) {
                $actionName = $file->getBasename('.php');
                $isAjax = $file->getPathInfo()->getBasename() == 'Ajax';
                $modules[] = $module;

                // ajax-files should be required
                if ($isAjax) {
                    $className = Classes::buildForAjax('Backend', $module, $actionName);
                } else {
                    $className = Classes::buildForAction('Backend', $module, $actionName);
                }

                $reflection = new \ReflectionClass($className);
                $phpDoc = trim($reflection->getDocComment());
                if ($phpDoc != '') {
                    $offset = strpos($reflection->getDocComment(), '*', 7);
                    $description = substr($reflection->getDocComment(), 0, $offset);
                    $description = str_replace('*', '', $description);
                    $description = trim(str_replace('/', '', $description));
                } else {
                    $description = '';
                }

                $this->actions[$module][] = array(
                    'label' => \SpoonFilter::toCamelCase($actionName),
                    'value' => $actionName,
                    'description' => $description
                );
            }
        }

        $modules = array_unique($modules);
        foreach ($modules as $module) {
            $this->modules[] = array(
                'label' => \SpoonFilter::toCamelCase($module),
                'value' => $module
            );
        }
    }
}