<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message = "Veuillez saisir un contenu"))
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePost", type="datetime")
     */
    private $datePost;

    /**
    * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\User", inversedBy="articles")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    /**
    * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Comment", mappedBy="article", cascade={"remove"})
    */
    private $comments;

    /**
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\ArticlePicture", cascade={"persist", "remove"})
    */
    private $articlePicture;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->datePost = new Datetime();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datePost
     *
     * @param \DateTime $datePost
     *
     * @return Article
     */
    public function setDatePost($datePost)
    {
        $this->datePost = $datePost;

        return $this;
    }

    /**
     * Get datePost
     *
     * @return \DateTime
     */
    public function getDatePost()
    {
        return $this->datePost;
    }

    /**
     * Set user
     *
     * @param \OC\PlatformBundle\Entity\User $user
     *
     * @return Article
     */
    public function setUser(\OC\PlatformBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\PlatformBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add comment
     *
     * @param \OC\PlatformBundle\Entity\Comment $comment
     *
     * @return Article
     */
    public function addComment(\OC\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \OC\PlatformBundle\Entity\Comment $comment
     */
    public function removeComment(\OC\PlatformBundle\Entity\Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set articlePicture
     *
     * @param \OC\PlatformBundle\Entity\ArticlePicture $articlePicture
     *
     * @return Article
     */
    public function setArticlePicture(\OC\PlatformBundle\Entity\ArticlePicture $articlePicture = null)
    {
        $this->articlePicture = $articlePicture;

        return $this;
    }

    /**
     * Get articlePicture
     *
     * @return \OC\PlatformBundle\Entity\ArticlePicture
     */
    public function getArticlePicture()
    {
        return $this->articlePicture;
    }
}
