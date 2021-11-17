<!-- model media start -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

<div class="modal fade bs-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel">Media</h4>
			</div>
			<div class="modal-body">
				<input type="test" class="form-control" id="recipient-name">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<form class="form-group" name="form" id="form" method="post" enctype="multipart/form-data" style="text-align:center; margin:10px auto; padding:10px 0px; border:dashed 3px #CCCCCC;">
							<div>Select File</div>
							<label class="btn btn-primary btn-file">
        Browse <input type="file" name="newfile" id="newfile"  style="display: none;">
        <input type="text" name="useridP" id="useridP" value="<?php echo $userloginID; ?>"  style="display: none;" />
    </label>

						</form>
					</div>
				</div>
				<div class="row" style="border-bottom:solid 1px #ccc;padding-bottom:8px;">
					<div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
						<form class="form-group" name="picFilter" id="picFilter" method="post" enctype="multipart/form-data" style="margin-bottom:0px;">
							<select class="Rselect-Group">
								<option>All</option>
								<option>Image</option>
								<option>Videos</option>
								<option>Audio</option>
								<option>Files</option>
								<option>Unattached</option>
							</select>
							<select class="Rselect-Group">
								<option>Nov 2014 </option>
								<option>Jan 2015</option>
								<option>Mar 2016</option>
								<option>Dec 2016</option>
								<option>Jan 2017</option>
								<option>Mar 2018</option>
							</select>
							<button type="submit" name="submit" class="btn btn-primary" style="margin-top:-3px;">Get Data</button>
						</form>
					</div>
					<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for..." disabled>
							<span class="input-group-btn">
              <button class="btn btn-default" type="button">Go!</button>
              </span>
							</div>
						<!-- /input-group -->
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 RiListPrnt" id="RiListPrnt">

						<?php 
	$upPic = mysqli_query($db, "select * from `pictures` where `pictures`.`pic_userid`='$userloginID' AND `pic_username`='$userName' AND `pic_status` IN ('on', 'approval') ORDER BY `pictures`.`pic_cre` DESC");
	while($upRow = mysqli_fetch_array($upPic)){
		$rs = round(filesize("../images/products/".$upRow['pic_picture'])/1024);
		$rd = date('M d, Y @ h:i A', strtotime($upRow['pic_cre'])); 
	echo "<div class='RiList' onclick='kontakte(this);'><i class='glyphicon glyphicon-trash Rxicon' aria-hidden='true' id='".$upRow['pic_id']."'></i><img src='../images/products/".$upRow['pic_picture']."' alt='".$upRow['pic_picture']."' rel='".$rs."' rd='".$rd."' rt='".$upRow['pic_type']."' /></div>";
	}
?>

						<!-- pagination start -->
						<!--<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo; Previous</span>
      </a>
    </li>
    <li class="active"><a href="#">1</a></li>
    <li><a href="#">2</a></li>
    <li><a href="#">3</a></li>
    <li><a href="#">4</a></li>
    <li><a href="#">5</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">Next &raquo;</span>
      </a>
    </li>
  </ul>
</nav>-->
						<!-- pagination end -->
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<table class="Rthead">
							<tr>
								<td>Uploaded on : </td>
								<td id="fdate" style="min-width: 160px;"></td>
							</tr>

							<tr>
								<td>File name : </td>
								<td id="fname"></td>
							</tr>
							<tr>
								<td>File type : </td>
								<td id="ftype"></td>
							</tr>
							<tr>
								<td>Dimenstions : </td>
								<td id="fdim"></td>
							</tr>
							<tr>
								<td>File Size : </td>
								<td id="fsize"></td>
							</tr>
							<tr>
								<td style="text-align:left !important;">File URL</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2"><input class="form-control" type="text" name="fileurl" id="fileurl" value="" readonly width="100%" placeholder="Select Picture" />
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
							</tr>
						</table>

						<div class="RiBtn">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary" id="selectimg">Select This</button>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- /.modal --> 
<script>
								$( '#newfile' ) . change( function ( e ) {
									e . preventDefault();
									//$("#message").empty();
									$( '#loading' ) . show();
									$ . ajax( {
										url: "ajax_image_uploads.php", // Url to which the request is send
										type: 'POST', // Type of request to be send, called as method
										data: new FormData( form ), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
										contentType: false, // The content type used when sending data to the server.
										cache: false, // To unable request pages to be cached
										processData: false, // To send DOMDocument or non processed data file it is set to false
										success: function ( data ) // A function to be called if request succeeds
											{
												$( '#loading' ) . hide();
												$( '#RupImgdiv' ) . html( '' );
												$( "#RiListPrnt" ) . html( data );
											},
										error: function () {
											alert( 'error' );
										}
									} );
								} );




								function kontakte( e ) {
									//var getthevalue = $( e ) . attr( 'id' );
									$( "i.Rricon" ) . remove();
									//$("i.Rxicon").remove();
									//alert($(e).find("img").attr('src')); //local url address
									//alert($(e).find("img")[0].src); //full url address
									var fullurl = $( e ) . find( "img" )[ 0 ] . src; //full url address
									//var myString = getthevalue . substr( getthevalue . indexOf( "_" ) + 1 )
										//alert(myString);
									$( e ) . append( "<i class='glyphicon glyphicon-ok-circle Rricon' aria-hidden='true'></i>" );
									$( '#fileurl' ) . val( fullurl );

									var w = $( e ) . find( "img" )[ 0 ] . naturalWidth;
									var h = $( e ) . find( "img" )[ 0 ] . naturalHeight;
									var s = $( e ) . find( "img" ) . attr( 'rel' );
									var n = $( e ) . find( "img" ) . attr( 'alt' );
									var d = $( e ) . find( "img" ) . attr( 'rd' );
									var t = $( e ) . find( "img" ) . attr( 'rt' );

									$( '#fdim' ) . html( 'w' + w + ' x h' + h );
									$( '#fsize' ) . html( s + ' KB' );
									$( '#fname' ) . html( n );
									$( '#fdate' ) . html( d );
									$( '#ftype' ) . html( t );

								}




								$( '#selectimg' ) . click( function () {
									var siinp = $( '#recipient-name' ) . val();
									var siurl = $( '#fileurl' ) . val();
									$( '#'+siinp ) . val( siurl );
									$( '#exampleModal' ) . modal( 'toggle' );
								} );



								$( '#exampleModal' ) . on( 'show.bs.modal', function ( event ) {
									var button = $( event . relatedTarget ) // Button that triggered the modal
									var recipient = button . data( 'whatever' ) // Extract info from data-* attributes
										// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
										// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
									var modal = $( this )
									$( '#recipient-name' ) . val( recipient );
									//modal.find('.modal-title').text('New messagerr to ' + recipient)
									//modal.find('.modal-body input').val(recipient)
								} )
								
								
							$('.Rxicon').click(function(){
										if (confirm('Are you sure to delete?')) {
									   var del_id = $(this).attr('id');
									   //var rowElement = $(this).parent().parent(); //grab the row
									   $.ajax({
												type:'POST',
												url:'ajax_image_uploads.php',
												data: 'delete_id='+del_id,
												success:function(data) {
														$('#loading').hide();
														$( '#RupImgdiv' ).html( '' );
														$("#RiListPrnt").html(data);
													},
													error: function(){
														alert('error');
													}   
												});
											}
										});									
								
</script>
<!-- model media end -->