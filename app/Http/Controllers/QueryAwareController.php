<?php

namespace App\Http\Controllers;

class QueryAwareController extends Controller
{
    /**
     * Creates the querystring for links to enable pagination and sorting to be remembered.
     * This is used when the response will be a view.
     *
     * @param  int  $page_number    Integer to override the Request pagination index.
     * @return string   $querystring    Querystring to append to links.
     */
    protected function createQuerystring(int $page_number = null)
    {
        $querystring = '';
        $page_qs_exists = $this->pageQuerystringExists();
        $search_qs_exists = $this->searchQuerystringExists();
        if ($page_qs_exists || !empty($page_number) || $search_qs_exists) {
            $querystring = '?';
            if (!empty($page_number)) {
                $querystring .= 'page=' . $page_number;
            } else {
                $querystring .= $page_qs_exists ? 'page=' . \Request::input('page') : '';
            }
            if ($search_qs_exists) {
                $querystring .= $querystring === '?' ? '' : '&';
                $querystring .= 'search=' . \Request::input('search');
            }
        }
        return $querystring;
    }

    /**
     * Creates the query variables for links to enable pagination and sorting to be remembered.
     * This is used when the response will be a redirect.
     *
     * @param  int  $page_number    Integer to override the Request pagination index.
     * @return array   $query_vars    An array of querystring variables to append to links.
     */
    protected function createQueryvars(int $page_number = null, bool $skip_search = null)
    {
        $query_vars = [];
        $page_qs_exists = $this->pageQuerystringExists();
        $search_qs_exists = $this->searchQuerystringExists();
        if ($page_qs_exists || !empty($page_number) || $search_qs_exists) {
            if (!empty($page_number)) {
                $query_vars['page'] = $page_number;
            } elseif ($page_qs_exists) {
                $query_vars['page'] = \Request::input('page');
            }
            if (!$skip_search && $search_qs_exists) {
                $query_vars['search'] = \Request::input('search');
            }
        }
        return $query_vars;
    }

    /**
     * Returns true if the 'page' querystring has been used
     *
     * @return bool   Returns true if the 'page' querystring has been used
     */
    protected function pageQuerystringExists()
    {
        return \Request::exists('page') && !empty(\Request::input('page'));
    }

    /**
     * Returns true if the 'search' querystring has been used
     *
     * @return bool   Returns true if the 'search' querystring has been used
     */
    protected function searchQuerystringExists()
    {
        return \Request::exists('search') && !empty(\Request::input('search'));
    }
}
