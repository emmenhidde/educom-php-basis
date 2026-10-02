<?php

// Beschrijft welke functies een identificatie moet hebben.
interface Identifier
{
	public function setId($id);

	public function getId();

	public function checkFileName();

	public function showImage();

	public function showPassport();
}

// Class bewaart een ID en imagenaam en toont het paspoort.
class User implements Identifier
{
	private $id;
	private $fileName;

	public function __construct($id, $fileName)
	{
		$this->id = $id;
		$this->fileName = $fileName;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function checkFileName()
	{
		// Controleert of het bestandstype jpg, png of gif is.
		$extension = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
		return in_array($extension, array('jpg', 'png', 'gif'));
	}

	public function showImage()
	{
		if (!$this->checkFileName()) {
			echo '<p class="status invalid">Geen geldige afbeelding</p>';
			return;
		}

		echo '<p class="status valid">Bestandstype is geldig</p>';
		echo '<img class="passport-photo" src="' . $this->fileName . '" alt="Identiteitsfoto">';
	}

	public function showPassport()
	{
		// Toont het ID, de bestandstype-status en de foto.
		echo '<main class="passport-card">';
		echo '<h1>Identiteitsbewijs</h1>';
		echo '<section class="passport-details">';
		echo '<p><strong>ID:</strong> ' . $this->getId() . '</p>';
		echo '</section>';
		echo '<section class="passport-details">';
		echo '<h2>Identificatiebestand</h2>';
		$this->showImage();
		echo '</section>';
		echo '</main>';
	}
}

