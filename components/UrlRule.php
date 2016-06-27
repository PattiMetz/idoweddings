<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;

class UrlRule implements UrlRuleInterface {

	/**
	 * Parses the given request and returns the corresponding route and parameters.
	 * @param \yii\web\UrlManager $manager the URL manager
	 * @param \yii\web\Request $request the request component
	 * @return array|boolean the parsing result. The route and the parameters are returned as an array.
	 * If false, it means this rule cannot be used to parse this path info.
	 */
	public function parseRequest($manager, $request) {

		$pathInfo = $request->getPathInfo();

		$pathInfo = trim($pathInfo, '/ ');

		switch ($pathInfo) {
			case 'admin/knowledgebases':
			case 'admin/knowledgebases/index':
				$route = 'admin-knowledgebases/index';
				break;
			case 'admin/knowledgebases/update':
				$route = 'admin-knowledgebases/update';
				break;
			case 'admin/knowledgebases/delete':
				$route = 'admin-knowledgebases/delete';
				break;
			case 'admin/knowledgebases/entries':
				$route = 'admin-knowledgebases/entries';
				break;
			case 'admin/knowledgebases/categories/update':
				$route = 'admin-knowledgebases/categories-update';
				break;
			case 'admin/knowledgebases/categories/delete':
				$route = 'admin-knowledgebases/categories-delete';
				break;
			case 'admin/knowledgebases/articles/update':
				$route = 'admin-knowledgebases/articles-update';
				break;
			case 'admin/knowledgebases/articles/delete':
				$route = 'admin-knowledgebases/articles-delete';
				break;
			case 'admin/knowledgebases/entries/files/upload':
				$route = 'admin-knowledgebases/entries-files-upload';
				break;
			default:
				$route = $pathInfo;
		}

		$params = array();

		return [$route, $params];

	}

	/**
	 * Creates a URL according to the given route and parameters.
	 * @param \yii\web\UrlManager $manager the URL manager
	 * @param string $route the route. It should not have slashes at the beginning or the end.
	 * @param array $params the parameters
	 * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
	 */
	public function createUrl($manager, $route, $params) {

		switch ($route) {
			case 'admin-knowledgebases/index':
				$url = 'admin/knowledgebases/index';
				break;
			case 'admin-knowledgebases/update':
				$url = 'admin/knowledgebases/update';
				break;
			case 'admin-knowledgebases/delete':
				$url = 'admin/knowledgebases/delete';
				break;
			case 'admin-knowledgebases/entries':
				$url = 'admin/knowledgebases/entries';
				break;
			case 'admin-knowledgebases/categories-update':
				$url = 'admin/knowledgebases/categories/update';
				break;
			case 'admin-knowledgebases/categories-delete':
				$url = 'admin/knowledgebases/categories/delete';
				break;
			case 'admin-knowledgebases/articles-update':
				$url = 'admin/knowledgebases/articles/update';
				break;
			case 'admin-knowledgebases/articles-delete':
				$url = 'admin/knowledgebases/articles/delete';
				break;
			case 'admin-knowledgebases/entries-files-upload':
				$url = 'admin/knowledgebases/entries/files/upload';
				break;
			default:
				return false;
		}

		$query = (count($params)) ? '?' . http_build_query($params) : '';

		return $url . $query;

	}

}
