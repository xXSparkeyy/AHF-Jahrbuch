<?php require_once( "db.php" );

	
	// Handles Gallery and images
	public class Gallery {

		private $id;
		private $images = [];



		public static function getImage( $id ) { //returns url for a single image by given id, eg avatar pics

		}
		public static function indexImage( $path ) { //adds image to the db, eg image upload

		}
		public static function deleteImage( $id ) { //deletes pic, eg accidently dick pic upload

		}
		public static function createGallery() { //deletes pic, eg accidently dick pic upload

		}



		public function addImage(  ) {

		}
		public function removeImage( $id ) {//removes

			deleteImage( $id );
		}
		public function getImages(  ) { //returns all images of this gallery
			return $this->images;
		}

		public function Gallery( $name, $createIfMissing=true ) {

		}


		private function loadImages() { //loads images in to the gallery

		}

	}

?>
