<?php
/**
 * Created by PhpStorm.
 * User: iuriguntchnigg
 * Date: 12/07/16
 * Time: 22:27
 */

namespace CodeProject\Services;


use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService {

  /**
   * @var ProjectRepository
   */
  protected $repository;

  /**
   * @var ProjectValidator
   */
  private $validator;

  /**
   * ProjectService constructor.
   *
   * @param ProjectRepository $repository
   * @param ProjectValidator   $validator
   */
  public function __construct(ProjectRepository $repository, ProjectValidator $validator) {

    $this->repository = $repository;
    $this->validator  = $validator;
  }

  /**
   * @param $data
   * @return Project
   */
  public function create (Array $data) {

    try {

      $this->validator->with($data)->passesOrFail();
      return $this->repository->create($data);
    } catch (ValidatorException $e) {
      return ["error" => true, 'message' => $e->getMessageBag()];
    }
  }

  /**
   * @param $id
   * @param $data
   * @return Project
   */
  public function update ($id, $data) {

    try {

      $this->validator->with($data)->passesOrFail();
      return $this->repository->update($data, $id);
    } catch (ValidatorException $e) {
      return ["error" => true, 'message' => $e->getMessageBag()];
    }

  }

}