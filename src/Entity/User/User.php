<?php declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\Trait\ActiveAware;
use App\Entity\Trait\CreatedAware;
use App\Entity\Trait\IdentifierAware;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[UniqueEntity(fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, EquatableInterface
{
    use IdentifierAware;
    use CreatedAware;
    use ActiveAware;

    public const DEFAULT_ROLE = 'ROLE_USER';

    #[ORM\Column(unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(max: 255)]
    protected ?string $email = null;

    #[ORM\Column(nullable: true)]
    protected ?string $password = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    protected ?string $firstName = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    protected ?string $lastName = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(max: 255)]
    protected ?string $title = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length(max: 255)]
    protected ?string $phone = null;

    #[ORM\Column(nullable: true)]
    protected ?string $avatar = null;

    #[ORM\Column(nullable: true)]
    protected ?string $providerId = null;

    public function getName(): string
    {
        return trim(sprintf('%s %s %s', $this->title, $this->firstName, $this->lastName));
    }

    public function getInitials(): string
    {
        return mb_substr($this->firstName, 0, 1).mb_substr($this->lastName, 0, 1);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getProviderId(): ?string
    {
        return $this->providerId;
    }

    public function setProviderId(?string $id): self
    {
        $this->providerId = $id;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRoles(): array
    {
        return [self::DEFAULT_ROLE];
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $this->getUserIdentifier() === $user->getUserIdentifier();
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function __serialize(): array
    {
        return [$this->id, $this->email];
    }

    public function __unserialize(array $data): void
    {
        [$this->id, $this->email] = $data;
    }
}
