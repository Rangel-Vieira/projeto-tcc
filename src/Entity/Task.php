<?php 

namespace Rangel\Tcc\Entity;
use DateTimeInterface;
use Rangel\Libs\Objectfy\Objectfy;

//TODO: regrinhas, só pode ter data de conclusão, se o status for concluído;
class Task {

    private ?int $id = 0;
    private ?string $title;
    private ?string $description;
    private ?DateTimeInterface $doneDate;
    private ?string $status;
    private ?string $imageUrl;

    public function __construct(int $id = null, string $title = null, string $description = null, DateTimeInterface $doneDate = null, 
        string $status = null, string $imageUrl = null){

            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->doneDate = $doneDate;
            $this->status = $status;
            $this->imageUrl = $imageUrl;
    }

    public function __toString(): string{
        return '[' .
               'id:'            . $this->id                                . ',' . 
               'title:'         . $this->title                             . ',' . 
               'description:'   . $this->description                       . ',' . 
               'doneDate:'      . $this->doneDate->format('d-m-y') ?? null . ',' . 
               'status:'        . $this->status                            . ',' .
               'imageUrl:'      . $this->imageUrl                          . ',' .
               ']';
    }

	/**
	 * @return array Retorna os campos que estão faltando, ou true se estiver ok
	 */
	public function isValid(): array | bool{
		$missing = [];
		if(empty($this->title))  { $missing[] = 'title';  }
		if(empty($this->status)) { $missing[] = 'status'; }

		return empty($missing) ? true : $missing;
	}

	/**
	 * @return integer
	 */
	public function getId(): int|null {
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
	public function getTitle(): string|null {
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
	public function getDescription(): string|null {
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
	public function getDoneDate(): DateTimeInterface|null {
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
	public function getStatus(): string|null {
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
	public function getimageUrl(): string|null {
		return $this->imageUrl;
	}
	
	/**
	 * @param string $imageUrl 
	 * @return self
	 */
	public function setimageUrl(string $imageUrl): self {
		$this->imageUrl = $imageUrl;
		return $this;
	}
}