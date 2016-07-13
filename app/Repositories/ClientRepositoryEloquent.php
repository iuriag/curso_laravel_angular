<?php
/**
 * Created by PhpStorm.
 * User: iuriguntchnigg
 * Date: 12/07/16
 * Time: 21:23
 */

namespace CodeProject\Repositories;


use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository  {

  public function model() {
    return Client::class;
  }
}