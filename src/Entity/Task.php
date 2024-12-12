<?php 

namespace Rangel\Tcc\Entity;
use DateTimeInterface;
use stdClass;

//TODO: regrinhas, só pode ter data de conclusão, se o status for concluído;
class Task {

    private ?int $id;
    private string $title;
    private string $description;
    private DateTimeInterface $doneDate;
    private string $status;
    private string $imageURL;

    public function __construct(int $id = null, string $title, string $description = null, DateTimeInterface $doneDate = null, 
        string $status, string $imageURL = null){

            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->doneDate = $doneDate;
            $this->status = $status;
            $this->imageURL = $imageURL;
    }

    public function __toString(): string{
        return '[' .
               'id:'. $this->id                               . ',' . 
               'title:' . $this->title                        . ',' . 
               'description:' . $this->description            . ',' . 
               'doneDate:' . $this->doneDate->format('d-m-y') . ',' . 
               'status:' . $this->status                      . ',' .
               'imageURL:' . $this->imageURL                  . ',' .
               ']';
    }

	public function parseToDatabase(): object{
		$parsed = new stdClass();
		
		$parsed->id = $this->id;
		$parsed->title = $this->title;
		$parsed->description = $this->description;
		$parsed->done_date = $this->doneDate->format('Y-m-d');
		$parsed->status = $this->status;
		$parsed->image_url = $this->imageURL;

		return $parsed;
	}

	/**
	 * @return integer
	 */
	public function getId(): int {
		return $this->id;
	}
	
	/**
	 * @param integer $id 
	 * @return self
	 */
	public function setId(int $id): self {
		$this->id = $id;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}
	
	/**
	 * @param string $title 
	 * @return self
	 */
	public function setTitle(string $title): self {
		$this->title = $title;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}
	
	/**
	 * @param string $description 
	 * @return self
	 */
	public function setDescription(string $description): self {
		$this->description = $description;
		return $this;
	}
	
	/**
	 * @return DateTimeInterface
	 */
	public function getDoneDate(): DateTimeInterface {
		return $this->doneDate;
	}
	
	/**
	 * @param DateTimeInterface $doneDate 
	 * @return self
	 */
	public function setDoneDate(DateTimeInterface $doneDate): self {
		$this->doneDate = $doneDate;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getStatus(): string {
		return $this->status;
	}
	
	/**
	 * @param string $status 
	 * @return self
	 */
	public function setStatus(string $status): self {
		$this->status = $status;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getImageURL(): string {
		return $this->imageURL;
	}
	
	/**
	 * @param string $imageURL 
	 * @return self
	 */
	public function setImageURL(string $imageURL): self {
		$this->imageURL = $imageURL;
		return $this;
	}
}