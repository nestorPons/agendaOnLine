'strict'
var estilos = {
	border : false , 
	init : function () {
		this.border = $('#sldBorderRadius').data('position') ;
	 },
	test : function ( value ) {
		this.border = value ;
		$('#btnTest').css('border-radius' , value)
	 },
	save : function () {
		var data = {
			color1 : $('#btnColor1').val() ,
			color2 : $('#btnColor2').val() ,
			border : this.border , 
			text1 : $('#btnText1').val() , 
			text2 : $('#btnText2').val() , 
			controller : 'estilos' , 
			action : SAVE
		}
		$.post(INDEX,data,function(r){ 
			if (r.success) location.reload() 
		},JSON)
	 }, 
	_getTheColor : function  (colorVal) {
		var theColor = "";
		if ( colorVal < 50 ) {
					myRed = 255;
					myGreen = parseInt( ( ( colorVal * 2 ) * 255 ) / 100 );
			}
		else 	{
					myRed = parseInt( ( ( 100 - colorVal ) * 2 ) * 255 / 100 );
					myGreen = 255;
			}
		theColor = "rgb(" + myRed + "," + myGreen + ",0)"; 
		return( theColor ); 
	}
 }

estilos.init()
function sliderConfigBorder ( value, slider ) {
	estilos.test( value ) 
 }