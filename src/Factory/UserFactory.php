<?php

namespace App\Factory;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFactory
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * @var UserPasswordHasherInterface $hasher
     */
    private $hasher;

    /**
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,
        UserPasswordHasherInterface $hasher
    ) {
        $this->em = $em;
        $this->logger = $logger;
        $this->hasher = $hasher;
    }

    /**
     * Create an User
     *
     * @param User|null $user
     * @param boolean $isVerified - default value = false
     * @param boolean $save - default value = true
     *
     * @return $user
     */
    public function createUser(
        User | null $user = null,
        bool $isVerified = false,
        bool $save = false
    ) {
        if (null === $user) {
            $user = new User;
        }
        if ($isVerified == true) {
            $user = $this->verifiedUser($user);
        }
        try {
            if ($save == true) {
                $user = $this->saveUser($user, true);
            }
        } catch (\Exception $ex) {
            $this->logger->error('An error occurred: ' . $ex->getMessage());
            throw $ex;
        }
        return $user;
    }

    /**
     * Create fake User
     *
     * @param User|null $user
     * @param string $role - default value = 'ROLE_USER'
     * @param boolean $isVerified - default value = true
     * @param boolean $save - default value = true
     *
     * @return $user
     */
    public function createFakeUser(
        User | null $user = null,
        string $role = 'ROLE_USER',
        bool $isVerified = true,
        bool $save = true
    ): User {

        if (null === $user) {
            $user = new User;
        }
        $uniqId = uniqid('john_', true);
        if (null == $user->getUsername()) {
            $user->setUsername($uniqId);
        }
        if (null == $user->getEmail()) {
            $user->setEmail($uniqId . 'n@doe.fak');
        }
        if (null == $user->getPassword()) {
            $pass = 'password1234';
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $this->hasher->hashPassword(
                $user,
                $pass
            );
            $user->setPassword($hashedPassword);
        }
        $roles = [];
        $roles[] = $role;
        $user->setRoles($roles);

        if ($isVerified == true) {
            $user = $this->verifiedUser($user);
        }
        try {
            if ($save == true) {
                $user = $this->saveUser($user, true);
            }
        } catch (\Exception $ex) {
            $this->logger->error('An error occurred: ' . $ex->getMessage());
            throw $ex;
        }
        return $user;
    }

    /**
     * Verified The User
     *
     * @param User $user
     * @param bool $isVerified - default value = true
     *
     * @return $user
     */
    private function verifiedUser(
        User $user,
        bool $isVerified = true
    ) {
        $user->setIsVerified($isVerified);
        return $user;
    }

    /**
     * Save The User
     *
     * @param User|null $user
     * @param bool $persist - default value = false - define if we persist or not
     *
     * @return $user
     */
    private function saveUser(
        User | null $user,
        bool $persist = false
    ) {

        if (null !== $user && $persist === true) {
            $this->em->persist($user);
        }
        $this->em->flush();
        return $user;
    }
}
