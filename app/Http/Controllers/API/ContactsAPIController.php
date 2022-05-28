<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\UserProjects;
use App\Repositories\ContactsRepository;
use App\Repositories\ProjectsRepository;
use Illuminate\Http\Request;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class ContactsAPIController extends Controller
{
    /** @var  ContactsRepository */
    private $contactRepository;

    public function __construct(ContactsRepository $contactRepo)
    {
        $this->contactRepository = $contactRepo;
    }

    /**
     * Display a listing of the Category.
     * GET|HEAD /categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
//        $cache_key = 'category_';
        try {
            $this->contactRepository->pushCriteria(new RequestCriteria($request));
            $this->contactRepository->pushCriteria(new LimitOffsetCriteria($request));


        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        $projects = $this->contactRepository->all();

//        Cache::forget($cache_key);
//        if (!Cache::has($cache_key)) {
//            $projects = Projects::get();
//            $projects->each(function ($c) {
//                $this->cleanCollection($c);
//            });
//            Cache::put($cache_key, $projects);
//        } else {
//            $projects = Cache::get($cache_key);
//        }

        return $this->sendResponse($projects, 'Contact retrieved successfully');
    }


    /**
     * Display the specified Category.
     * GET|HEAD /categories/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
//        $cache_key = 'project_' . $id;
        /** @var Projects $projects */
        if (!empty($this->contactRepository)) {
            try {
                $this->projectsRepository->pushCriteria(new RequestCriteria($request));
                $this->projectsRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                return $this->sendError($e->getMessage());
            }

            $project = $this->projectsRepository->findWithoutFail($id);
        }
        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        return $this->sendResponse($project->toArray(), 'Project retrieved successfully');
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            $project = $this->contactRepository->create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'contact_id' => $input['contact_id'],
            ]);



        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($project->toArray(), __('lang.saved_successfully'));
    }

    /**
     * Update the specified Category in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $project = $this->contactRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }
        $input = $request->all();
        try {
            $project = $this->contactRepository->update($input, $id);

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($project->toArray(), __('lang.updated_successfully'));

    }

    /**
     * Remove the specified Category from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project = $this->contactRepository->findWithoutFail($id);

        if (empty($project)) {
            return $this->sendError('Project not found');
        }

        $project = $this->contactRepository->delete($id);

        return $this->sendResponse($project, __('lang.deleted_successfully'));
    }

}
