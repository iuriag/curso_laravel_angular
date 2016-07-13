<?php
/**
 * Created by PhpStorm.
 * User: iuriguntchnigg
 * Date: 12/07/16
 * Time: 22:27
 */

namespace CodeProject\Services;


use CodeProject\Entities\Client;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService {

  /**
   * @var ClientRepository
   */
  protected $repository;

  /**
   * @var ClientValidator
   */
  private $validator;

  /**
   * ClientService constructor.
   *
   * @param ClientRepository $repository
   * @param ClientValidator  $validator
   */
  public function __construct(ClientRepository $repository, ClientValidator $validator) {

    $this->repository = $repository;
    $this->validator  = $validator;
  }

  /**
   * @param $data
   * @return Client
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
   * @return Client
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