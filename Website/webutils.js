function hideLogin() {
    document.getElementById("logincontainer").style.display = "none";
}

function hideCL() {
    document.getElementById("clcontainer").style.display = "none";
}
function hideJL() {
    document.getElementById("jlcontainer").style.display = "none";
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
var clMusic = new Audio('../sound/title.mp3');
var createLeagueOverlay = {
    
    show: function() {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1

        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            createLeagueOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: createLeagueOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {createLeagueOverlay.hide(); hideCL();};
        } else {
            createLeagueOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("clcontainer").style.display = "block";
        clMusic.play();
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
        clMusic.pause();
        clMusic.currentTime = 0;
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
var leagueid;
var lid;
var joinLeagueOverlay = {
    
    
    show: function(leagueid) {
        
        var color = 'black'; // SET THE COLOR HERE (IT CAN BE A HEX COLOR e.g. #FF00FF)
        var opacity = 0.7; // SET AN OPACITY HERE - MUST BE BETWEEN 0 AND 1
        lid = leagueid;
        var o = document.getElementById('doc_overlay');
        if(!o) {
            var o = document.createElement('div');
            o.id = "doc_overlay";
            createLeagueOverlay.style(o,{
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: joinLeagueOverlay.getDocHeight()+'px',
                background: color,
                zIndex: 1000,
                opacity: opacity,
                filter: 'alpha(opacity='+opacity*100+')'
            });
            document.getElementById('body').appendChild(o);
            o.onclick = function() {joinLeagueOverlay.hide(); hideJL();};
        } else {
            joinLeagueOverlay.style(o,{background:color||'#000',display:'block'});
        }
        document.getElementById("jlcontainer").style.display = "block";
        document.getElementById("jlbutton").onclick = function() {joinLeagueOverlay.sendJLRequest();};
        clMusic.play();
    },
    hide: function() {
        var o = document.getElementById('doc_overlay');
        o.style.display = 'none';
        clMusic.pause();
        clMusic.currentTime = 0;
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
    },
        
    sendJLRequest: function() {
        document.getElementById("jltest").innerHTML = "This is a test."
        request = new XMLHttpRequest();
        request.onreadystatechange = handleJLResponse;
        request.open("POST","rpc/rpc.php",true);
        request.setRequestHeader("Content-type","application/json");
        var data = JSON.stringify({request:"jl",lid:lid});
        request.send(data);
    },
    handleJLResponse: function() {
        window.top.location.href = "myaccount.php";
    }
}