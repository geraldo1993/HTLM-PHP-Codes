<script type="text/javascript">

                var image1=new Image()
                image1.src="MVP.jpg"
                var image2=new Image()
                image2.src="nothing.jpg"
                var image3=new Image()
                image3.src="mainsoccerslide.jpg"


                </script>
 <script type="text/javascript">
			
				var step=1
				function slideit(){
				document.images.slide.src=eval("image"+ step +".src")
				if(step<3)
					step++
				else
					step=1
					setTimeout("slideit()",2500)
				}
				slideit()
				</script>