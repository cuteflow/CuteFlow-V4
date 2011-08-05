<?php

namespace CuteFlow\CoreBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use CuteFlow\CoreBundle\Model\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cf_user")
 * @ORM\Entity(repositoryClass="CuteFlow\CoreBundle\Model\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    const ROLE_CUTEFLOW_ADMIN = 'ROLE_CUTEFLOW_ADMIN';
    const ROLE_CUTEFLOW_USER = 'ROLE_CUTEFLOW_USER';
    const ROLE_CUTEFLOW_DEFAULT = 'ROLE_CUTEFLOW_DEFAULT';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length="32", unique=true)
     */
    protected $username;
    /**
     * @ORM\Column(type="string", length="255")
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length="128")
     */
    protected $password;

    /**
     * not persisted, only for validation
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="roles", type="array")
     * @var ArrayCollection $roles
     */
    protected $roles;

    /**
     * @ORM\Column(type="string", length="5", nullable=true)
     * @var String
     */
    protected $locale;

    /**
     * @ORM\Column(type="string", length="100", nullable=true)
     * @var String
     */
    protected $theme;

    /**
     * @var string $lastName
     *
     * @ORM\Column(name="last_name", type="string", length="255")
     */
    protected $lastName;

    /**
     * @var string $firstName
     *
     * @ORM\Column(name="first_name", type="string", length="255")
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var \DateTime
     *
     * @ORM\column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length="255")
     */
    protected $salt;

    /**
     * @var \DateTime
     *
     * @ORM\column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     *
     * @ORM\ManyToMany(targetEntity="UserGroup", inversedBy="users")
     * @ORM\JoinTable(name="cf_user_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    protected $groups;


    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @return void
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     * @return void
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * Constructs a new instance of User
     */
    public function __construct()
    {
        $this->roles = array();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Implementing the UserInterface interface
     */
    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * Gets an array of roles.
     *
     * @return array An array of Role objects
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // make sure to have at least one role
        $roles[] = self::ROLE_CUTEFLOW_DEFAULT;

        return array_unique($roles);
    }

    /**
     * @param string $rolename
     * @return boolean
     */
    public function hasRole($rolename)
    {
        return in_array(strtoupper($rolename), $this->getRoles(), true);
    }

    /**
     * Removes a role to the user.
     *
     * @param string $role
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * equals.
     *
     * @param UserInterface $account
     * @return bool
     */
    public function equals(UserInterface $account)
    {
        if ($account->getUsername() != $this->getUsername()) {
            return false;
        }
        if ($account->getEmail() != $this->getEmail()) {
            return false;
        }
        return true;
    }


    /**
     * Set theme
     *
     * @param string $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastLogin
     *
     * @param datetime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * Get lastLogin
     *
     * @return datetime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->hasRole(User::ROLE_CUTEFLOW_ADMIN);
    }

    public function setAdmin($value)
    {
        if ($value != $this->isAdmin()) {
            if ($value == true) {
                $this->addRole(User::ROLE_CUTEFLOW_ADMIN);
            }
            else {
                $this->removeRole(User::ROLE_CUTEFLOW_ADMIN);
            }

        }
    }

    /**
     * Set roles
     *
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Adds a role to the user.
     *
     * @param string $role
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === self::ROLE_CUTEFLOW_DEFAULT) {
            return;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }
    }

    /**
     * Set deletedAt
     *
     * @param datetime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * Get deletedAt
     *
     * @return datetime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * Add groups
     *
     * @param CuteFlow\CoreBundle\Entity\UserGroup $groups
     */
    public function addGroups(\CuteFlow\CoreBundle\Entity\UserGroup $groups)
    {
        $this->groups[] = $groups;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Gets the name of the groups which includes the user.
     *
     * @return array
     */
    public function getGroupNames()
    {
        $names = array();
        foreach ($this->getGroups() as $group) {
            $names[] = $group->getName();
        }

        return $names;
    }
}