    var i=0;
    function read(){
        if(!i){
            document.getElementById("more").style.display="inline";
            document.getElementById("dots").style.display="none";
            document.getElementById("read").innerHTML="Citeste mai putin";
            i=1;
        }
        else{
            document.getElementById("more").style.display="none";
            document.getElementById("dots").style.display="inline";
            document.getElementById("read").innerHTML="Citeste mai mult";
            i=0;
        }
    }