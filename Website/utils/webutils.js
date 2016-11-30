function hideLogin() {
    document.getElementById("logincontainer").style.display = "none";
}

function openNav() {
    document.getElementById("sidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("sidenav").style.width = "0";
}

var loginOverlay = {
    show: function() {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1

        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            loginOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: loginOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {loginOverlay.hide(); hideLogin();};
        } else {
            loginOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("logincontainer").style.display = "block";
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
    },
    style: function(obj,s) {
        for ( var i in s ) {
            obj.style[i] = s[i];
        }
    },
    getDocHeight: function() {
        var Y,YT;
        if( self.innerHeight ) {Y = self.innerHeight;}
        else if (document.documentElement && document.documentElement.clientHeight) {Y = document.documentElement.clientHeight;} 
        if( document.body ) {YT = document.body.clientHeight;}
        if(YT>Y) {Y = YT;}
        return Y;
    }
}