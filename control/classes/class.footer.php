<?php
class Footer{
public static function doFooter()
{
  ?>
</div>
		</div>
		<!--footer-->
		<div class="footer">
		   <p>&copy; 2018 Farmorders Admin Panel. All Rights Reserved | Visit <a href="https://farmorders.com.ng/" target="_blank">site</a></p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="includes/dash/js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="includes/dash/js/jquery.nicescroll.js"></script>
	<script src="includes/dash/js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="includes/dash/js/bootstrap.js"> </script>
</body>
</html>


 <?php
  }
  }
?>