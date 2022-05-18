<?php

namespace App\Transformers;

use App\Exceptions\UnsupportedFractalIncludeException;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract as FractalTransformer;

/**
 * Class Transformer
 * @package App\Transformers
 * @author  Adnane Nejbah <0664310785> <adnane.nejbah.dev@gmail.com | adnane.nejbah.dev@outlook.com>
 */
abstract class Transformer extends FractalTransformer
{

	public function defaultResponse($entity, $response = []):array
	{
		$key = $entity->getMorphClass();
		$createdAt = get($entity, "created_at", null);
		$updatedAt = get($entity, "updated_at", null);

		return array_merge([
			'object'              => Str::ucfirst($key),
			'key'                 => $key,
			'status'              => $this->get($entity, "status", true),
			'created_at'          => $createdAt,
			'updated_at'          => $updatedAt,
			'readable_created_at' => $createdAt != null ? $createdAt->diffForHumans() : null,
			'readable_updated_at' => $updatedAt != null ? $updatedAt->diffForHumans() : null,
		], $response);
	}

	public function get($array, $key, $default = null)
	{
		return array_get($array, $key, $default);
	}

	/**
	 * @param $adminResponse
	 * @param $clientResponse
	 *
	 * @return  array
	 */
	public function ifAdmin($adminResponse, $clientResponse)
	{
		/** @var \App\Models\User $user */
		$user = $this->user();

		if (!is_null($user) && $user->hasAdminRole())
		{
			return array_merge($clientResponse, $adminResponse);
		}

		return $clientResponse;
	}

	/**
	 * @return  mixed
	 */
	public function user()
	{
		return Auth::user();
	}

	/**
	 * @param mixed $data
	 * @param callable|FractalTransformer $transformer
	 * @param null $resourceKey
	 *
	 * @return \League\Fractal\Resource\Item
	 */
	public function item($data, $transformer, $resourceKey = null)
	{
		// set a default resource key if none is set
		if (!$resourceKey && $data)
		{
			$resourceKey = $data->getResourceKey();
		}

		return parent::item($data, $transformer, $resourceKey);
	}

	/**
	 * @param mixed $data
	 * @param callable|FractalTransformer $transformer
	 * @param null $resourceKey
	 *
	 * @return \League\Fractal\Resource\Collection
	 */
	public function collection($data, $transformer, $resourceKey = null)
	{
		// set a default resource key if none is set
		if (!$resourceKey && $data->isNotEmpty())
		{
			$modelKeys = $data->modelKeys();
			$resourceKey = (string)$modelKeys[array_keys($modelKeys)[0]];
		}

		return parent::collection($data, $transformer, $resourceKey);
	}

	/**
	 * @param Scope $scope
	 * @param string $includeName
	 * @param mixed $data
	 *
	 * @return \League\Fractal\Resource\ResourceInterface
	 * @throws UnsupportedFractalIncludeException
	 */
	protected function callIncludeMethod(Scope $scope, $includeName, $data)
	{
		try
		{
			return parent::callIncludeMethod($scope, $includeName, $data);
		} catch (ErrorException $exception)
		{
		    throw new UnsupportedFractalIncludeException($exception->getMessage());
		}
	}

}
