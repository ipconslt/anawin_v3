<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 *  * @UniqueEntity("titre")
 * @Vich\Uploadable
 */
class Articles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 200,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     * )
     */
    private $titre;

  /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

     /**
     * @var \DateTime $created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    /**
     * @var \DateTime $updated_at
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @var string
     */
    private $featured_image;

    /**
     * @Vich\UploadableField(mapping="featured_images", fileNameProperty="featured_image")
     * @var File
     */
    private $imageFile;    

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="articles")
     */
    public $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     */
    private $comments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->categorie = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getSlug();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }


    public function getFeaturedImage()
    {
        return $this->featured_image;
    }

    public function setFeaturedImage($featured_image)
    {
        $this->featured_image = $featured_image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
    
        if ($image) {
            $this->updated_at = new \DateTime('now');
        }
    }
    
    public function getImageFile()
    {
        return $this->imageFile;
    }


    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categorie->contains($category)) {
            $this->categorie[] = $category;
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categorie->contains($category)) {
            $this->categorie->removeElement($category);
        }

        return $this;
    }
    

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    public function getSlug(): string
    {
       /*
        $slugify = new Slugify();
        echo $slugify->slugify('Hello World!'); // hello-world
        */

        return (new Slugify())-> slugify($this->titre);
    }

/*    public function setSlug(string $slug): self
    {
        $this->titre = $slug;

        return $this;
    }*/

}
