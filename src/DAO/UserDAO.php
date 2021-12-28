<?php

    namespace App\src\DAO;

    use App\config\Post;
    use App\src\model\User;

    class UserDAO extends DAO
    {
        public function register(Post $superGlobalData, $createdAt, $token)
        {
            $sql = 'INSERT INTO user (username, password, created_at, email, token) VALUES(:username, :password, :created_at, :email, :token)';
            $this->creatQuery($sql, [
                'username' => $superGlobalData->getParameter('username'),
                'password' => password_hash($superGlobalData->getParameter('password'), PASSWORD_BCRYPT),
                'created_at' => $createdAt,
                'email' => $superGlobalData->getParameter('email'),
                'token' => $token
            ]);
        }

        public function getToken($id)
        {
            $sql = 'SELECT token FROM user WHERE id = :id ';
            return $this->creatQuery($sql, ['id' => $id])->fetch();
        }

        public function activateAccount($id)
        {
            $sql = 'UPDATE user SET token = :token, status = :status WHERE id = :id ';
            $this->creatQuery($sql, [
                'token' => null,
                'status' => 1,
                'id' => $id
            ]);
        }

        public function lastId()
        {
            $sql = 'SELECT id FROM user WHERE id=LAST_INSERT_ID()';
            return ($this->creatQuery($sql)->fetch());
        }

        public function checkDuplicateUsername($username)
        {
            $sql = 'SELECT username FROM user WHERE username=:username ';
            $dbResult = $this->creatQuery($sql, [
                'username' => $username,
            ]);
            $result = $dbResult->fetch();
            if (!empty($result)) {
                return true;
            } else {
                return false;
            }
        }

        public function checkDuplicate($data, $value)
        {
            if ($value = 'username') {
                $sql = 'SELECT username FROM user WHERE username=:username ';
            }
            if ($value = 'email') {
                $sql = 'SELECT email FROM user WHERE email=:email ';
            }

            $dbResult = $this->creatQuery($sql, [
                $value => $data,
            ]);
            $result = $dbResult->fetch();
            $duplicate['match'] = [
                $value => $result[$value],
            ];
            return $duplicate;
        }

        public function checkDuplicateEmail($email)
        {
            $sql = 'SELECT email FROM user WHERE email=:email ';
            $dbResult = $this->creatQuery($sql, [
                'email' => $email,
            ]);
            return $dbResult->fetch();
        }

        public function login(Post $superGlobalData)
        {
            $sql = 'SELECT  id, password, role, status, email FROM user WHERE username = :username';
            $data = $this->creatQuery($sql, [
                'username' => $superGlobalData->getParameter('username')
            ]);
            $result = $data->fetch();

            if (!$result) {
                return [
                    'password' => null,
                    'status' => null
                ];
            } else {
                return
                    $result;
            }
        }

        public function updatePassword(Post $superGlobalData, $username)
        {
            $sql = 'UPDATE user SET password = :password WHERE username = :username';
            $this->creatQuery($sql, [
                'password' => password_hash($superGlobalData->getParameter('password'), PASSWORD_BCRYPT),
                'username' => $username]);
        }

        public function updateEmail($username, $email)
        {
            $sql = 'UPDATE user SET email = :email WHERE username = :username';
            $this->creatQuery($sql, [
                'email' => $email,
                'username' => $username]);
        }

        public function deleteAccount($id)
        {
            $sql = 'DELETE FROM user WHERE id = :id ';
            $this->creatQuery($sql, [
                'id' => $id
            ]);
        }

        public function getUsersList()
        {
            $sql = 'SELECT id, username, created_at, role, status FROM user ORDER BY id DESC';
            $result = $this->creatQuery($sql);
            $users = [];
            foreach ($result as $user) {
                $userId = $user['id'];
                $users[$userId] = $this->buildObject($user);
            }
            $result->closeCursor();
            return $users;
        }

        private function buildObject($row)
        {
            $user = new User();
            $user->setId($row['id']);
            $user->setUsername($row['username']);
            $user->setCreatedAt($row['created_at']);
            $user->setRole($row['role']);
            $user->setStatus($row['status']);
            return $user;
        }

        public function banOrActiveUser($id, $status)
        {
            $sql = 'UPDATE user SET status = :status WHERE id = :id';
            $this->creatQuery($sql, [
                'status' => $status,
                'id' => $id
            ]);
        }
    }