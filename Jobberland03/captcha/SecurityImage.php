<?php
session_start();
/**
 *	SecurityImage.php
 *
 *	Class to implement Captcha security Images
 *	to combat Spam, using PHP/GD
 *
 *	@author			A.D.Surrey. (www.surneo.com)
 * 	@version		1.3
 */

class SecurityImage
{
	var	$bg,
		$image,
		$font,					// Located in fonts folder.
		$fontsize,
		$colour,					// Colour of text
		$strLength,					// Length of random Text
		$text = "",
		$num_dots,					// Num of noise dots to add
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");

		/**
		 * Constructor, setup initial values.
		 *
		 * @return SecurityImage
		 */
		function SecurityImage()
		{
			$this->strLength = 5;//$_SESSION['spam_code_length'];
			$this->fontsize = 14;
			$this->num_dots = 300; // How much Noise to add.

			$this->selectFont(); // Decide which Font to use.

			$bg = "images/" . mt_rand(1,7) . ".png"; // Set bg to use.
			$this->image = imagecreatefrompng($bg);
			if ($this->strLength > 5) {
			/* Extend the background picture size */
				$width = imagesx($this->image);
				$height = imagesy($this->image);
				$nw = ($width / 5)* $this->strLength;
				$img2 = imagecreatetruecolor( $nw, $height );
				imagecopyresampled ( $img2, $this->image, 0, 0, 0 , 0, $nw, $height, $width, $height );
				$this->image = $img2;
			}

			$this->colour = ImageColorAllocate ($this->image, 0, 0, 0); // Black

			/**
			 * Automatically show when object created.
			 */
			$this->show();

			/**
			 * Set session varible so our form can compare the text
			 * to users input
			 */
			$_SESSION['spam_code'] = $this->text;
		}
	/**
	 * Display our Captcha image
	 *
	 */
	function show()
	{
		Header ("Content-type: image/png");

		$this->text = $this->genString();

		/**
		 * write each letter to image
		 */
		for($i = 0; $i < $this->strLength; $i++)
		{
			$this->writeLetter($this->text[$i],(20 + $i * 25));
		}

		$this->addNoise();

		imagepng($this->image);
		imagedestroy($this->image);
	}

	/**
	 * Generate a random string for our image
	 * using the caracters in our array.
	 *
	 */
	function genString()
	{
		for ($i = 0; $i < $this->strLength; $i++)
		{
   			$this->text .= $this->chars[mt_rand(0, count($this->chars) - 1)];
		}

		return $this->text;
	}

	/**
	 * writes a single letter to the image, using random angles/colours
	 *
	 */
	function writeLetter($letter ,$xvalue)
	{
		$yvalue = 30 - mt_rand(0, 10); // Randomly adjust y position.
		$angle = mt_rand(-30,30);// Give text a slight random angle.

		imagettftext($this->image, $this->fontsize, $angle, $xvalue, $yvalue, $this->colour, $this->font, $letter);
	}

	/**
	 * Compares the given text to the one in the Security
	 * Image.
	 *
	 * @return true if the text matches.
	 */
	function isMatch($t)
	{
		if($t == $this->text)
		{
			return true;
		}
		else return false;
	}

	/**
	 * function to add extra "noise"
	 * or random dots to the image
	 *
	 */
	function addNoise()
	{
		$width = imagesx($this->image);
		$height = imagesy($this->image);

		//random dots.
		for($i = 0; $i < $this->num_dots; $i++)
		{
			imagefilledellipse($this->image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $this->colour);
		}
	}

	/**
	 * Chose a random TTF Font to use for out Captcha Text.
	 *
	 */
	function selectFont()
	{
		switch (mt_rand(1,3))
		{
			case 1 : $this->font = "fonts/Acidic.TTF"; break;
			case 2 : $this->font = "fonts/arial.ttf"; break;
			case 3 : $this->font = "fonts/frizzed.ttf"; break;
			//case 4 : $this->font = "fonts/STACKZ.TTF"; break;
		}
	}
}

/**
 * Create a new object when we include this file.
 */
$secim = new SecurityImage();
?>