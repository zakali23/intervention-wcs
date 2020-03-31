<?php

/**
 * PHP version 7
 */

namespace Controller;

use Model\User;
use Model\UserManager;

/**
 * Class UserController
 */
class UserController extends AbstractController
{

  /**
   * Display index
   * @return string
   */
  public function index()
  {

    return $this->twig->render('Home/index.html.twig');
  }

  /**
   * Display items users format json
   * @return array
   */
  public function fetchAllUsers()
  {
    $userManager = new UserManager();
    $users = $userManager->selectAll();
    $data = json_encode($users, true);
    return $data;
  }


  /**
   * Display item creation page
   *
   * @return response
   */
  public function addUSer()
  {

    $userPost = $_POST['user'];
    $encodeUser = json_decode($userPost);

    if ($encodeUser) {

      $user = new User();
      $user->setFirstName($encodeUser->firstName);
      $user->setLastName($encodeUser->lastName);
      $user->setAddress($encodeUser->address);
      $user->setAddress2($encodeUser->address2);
      $user->setZipCode($encodeUser->zipCode);
      $user->setCity(strtoupper($encodeUser->city));
      $userManager = new UserManager();
      $data = [
        'lastName' => $user->getLastName(),
        'firstName' => $user->getFirstName(),
        'address' => $user->getAddress(),
        'address2' => $user->getAddress2(),
        'zipCode' => $user->getZipCode(),
        'city' => $user->getCity()

      ];
      $userManager->add($data);
      return http_response_code(201);
    }
  }
  /**
   * Edit User by id
   * @param int $id
   * @return string
   */
  public function editUser($id)
  {
    $userPost = $_POST['user'];
    $decodeUser = json_decode($userPost);
    $data = [
      'lastName' => $decodeUser->lastName,
      'firstName' => $decodeUser->firstName,
      'address' => $decodeUser->address,
      'address2' => $decodeUser->address2,
      'zipCode' => $decodeUser->zipCode,
      'city' => $decodeUser->city
    ];
    $userManager = new UserManager();
    $userManager->update($id, $data);
    return json_encode('user update');
  }

  /**
   * 
   *  Delete User by id
   *  @param int $id
   */
  public function delUser(int $id)
  {

    $userManager = new UserManager();
    $userManager->delete($id);
    return json_encode('delete user');
  }

  /**
   *
   *  search User by name
   * @param string $search
   *
   * @return string
   */
  public function search($search)
  {
    $response = [];
    if ($search) {
      $userManager = new UserManager();
      $users = $userManager->searchByName($search);
      if ($users) {
        $response = [
          'data' => $users,
          'status' => 200
        ];
        return json_encode($response);
      }
      return json_encode($response = [
        'data' => [],
        'status' => 200
      ]);
    }
  }
}
