var mr = 0;

export function sliderAdaptive(){
    return 'adaptive';
}

export function switcher( direction ){

	let cat = document.getElementById('switch-category'),
		wd = cat.clientWidth,
		li = cat.getElementsByTagName('li').length,
		liWd = wd / li;
	console.log(cat, wd, li, liWd);
	switch(direction) {
      case 'right':  
        sliderToLeft( wd, liWd );
        break;
      case 'left':          
        sliderToRight( wd, liWd );
        break;     
    }	
    return direction;
}

function sliderToRight( wd, liWd ){    
	console.log('sliderToRight', mr);
	let cat = document.getElementById('switch-category');
    if(mr < 0){
        mr += liWd;        
        cat.style.cssText = "margin-left:" + mr + "px;";         
    }    
};

function sliderToLeft( wd, liWd ){
	console.log('sliderToLeft', mr);
	let cat = document.getElementById('switch-category');
    if( mr > -wd + liWd){
        mr -= liWd;        
        cat.style.cssText = "margin-left:" + mr + "px;";         
    }
};