<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>    
    <title>Pokemon Trainer DB</title>
    <script src="webutils.js" language="javascript"></script>
</head>
<body id="body" onload="tdbRequest('none')"> 

    <?php
        include "/var/lib/pokelibs/webutils/layout.php"
    ?>
    
    <!---page info --->
    <div id="container">
    <div id="header"> <h1>Trainer Database</h1> </div>

    <div id="contents">
        <div id="search">
            <h3>Search</h3>
            
            <input id="searchbar" type="text" name="tid"/><br><br>
            <input type="submit" value="Search" onclick="tdbRequest('none')"/>
            <p><font size="1pt">
            Search by: <br>trainer type <br>trainer name <br>pokemon</p>

        </div>
    <div id="table">
        <p id="tdb"></p>
    </div>
    </div>

    <?php
        include "/var/lib/pokelibs/webutils/footer.php"
    ?>
</div>
</body>

</html>