<?php

namespace Frontend\Modules\Blog\Actions;

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

use Frontend\Core\Engine\Base\Block as FrontendBaseBlock;
use Frontend\Core\Language\Language as FL;
use Frontend\Core\Engine\Navigation as FrontendNavigation;
use Frontend\Modules\Blog\Engine\Model as FrontendBlogModel;

/**
 * This is the category-action
 */
class Category extends FrontendBaseBlock
{
    /**
     * The articles
     *
     * @var array
     */
    private $items;

    /**
     * The requested category
     *
     * @var array
     */
    private $category;

    /**
     * The pagination array
     * It will hold all needed parameters, some of them need initialization
     *
     * @var array
     */
    protected $pagination = array(
        'limit' => 10,
        'offset' => 0,
        'requested_page' => 1,
        'num_items' => null,
        'num_pages' => null,
    );

    /**
     * Execute the extra
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->getData();
        $this->parse();
    }

    /**
     * Load the data, don't forget to validate the incoming data
     */
    private function getData()
    {
        // get categories
        $categories = FrontendBlogModel::getAllCategories();
        $possibleCategories = array();
        foreach ($categories as $category) {
            $possibleCategories[$category['url']] = $category['id'];
        }

        // requested category
        $requestedCategory = \SpoonFilter::getValue(
            $this->URL->getParameter(1, 'string'),
            array_keys($possibleCategories),
            'false'
        );

        // requested page
        $requestedPage = $this->URL->getParameter('page', 'int', 1);

        // validate category
        if ($requestedCategory == 'false') {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        // set category
        $this->category = $categories[$possibleCategories[$requestedCategory]];

        // set URL and limit
        $this->pagination['url'] = FrontendNavigation::getURLForBlock('Blog', 'Category') . '/' . $requestedCategory;
        $this->pagination['limit'] = $this->get('fork.settings')->get('Blog', 'overview_num_items', 10);

        // populate count fields in pagination
        $this->pagination['num_items'] = FrontendBlogModel::getAllForCategoryCount($requestedCategory);
        $this->pagination['num_pages'] = (int) ceil($this->pagination['num_items'] / $this->pagination['limit']);

        // redirect if the request page doesn't exists
        if ($requestedPage > $this->pagination['num_pages'] || $requestedPage < 1) {
            $this->redirect(FrontendNavigation::getURL(404));
        }

        // populate calculated fields in pagination
        $this->pagination['requested_page'] = $requestedPage;
        $this->pagination['offset'] = ($this->pagination['requested_page'] * $this->pagination['limit']) - $this->pagination['limit'];

        // get articles
        $this->items = FrontendBlogModel::getAllForCategory(
            $requestedCategory,
            $this->pagination['limit'],
            $this->pagination['offset']
        );
    }

    /**
     * Parse the data into the template
     */
    private function parse()
    {
        // get RSS-link
        $rssTitle = $this->get('fork.settings')->get('Blog', 'rss_title_' . LANGUAGE);
        $rssLink = FrontendNavigation::getURLForBlock('Blog', 'Rss');

        // add RSS-feed
        $this->header->addRssLink($rssTitle, $rssLink);

        // add into breadcrumb
        $this->breadcrumb->addElement(\SpoonFilter::ucfirst(FL::lbl('Category')));
        $this->breadcrumb->addElement($this->category['label']);

        // set pageTitle
        $this->header->setPageTitle(\SpoonFilter::ucfirst(FL::lbl('Category')));
        $this->header->setPageTitle($this->category['label']);

        // advanced SEO-attributes
        if (isset($this->category['meta_data']['seo_index'])) {
            $this->header->addMetaData(
                array('name' => 'robots', 'content' => $this->category['meta_data']['seo_index'])
            );
        }
        if (isset($this->category['meta_data']['seo_follow'])) {
            $this->header->addMetaData(
                array('name' => 'robots', 'content' => $this->category['meta_data']['seo_follow'])
            );
        }

        // assign category
        $this->tpl->assign('category', $this->category);

        // assign articles
        $this->tpl->assign('items', $this->items);

        // parse the pagination
        $this->parsePagination();
    }
}
