	</div>

</div>
 
	<div id="wrapfooter">
	<div id="footer">

	<div id="chat">
    	<div id="room"><dl></dl></div>
    	<form action="#" method="post">
    	    <input type="hidden" name="user" value="<?php echo $_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom']; ?>" size="7"/>
    	    <input type="text" name="message" size="30" AUTOCOMPLETE="off" />
    	    <input type="submit" value="OK" />
    	</form>
	</div>
	
	<div id="connectes">
		
		<?php printStudentConnectes(); ?>
		
	</div>
	
    <div id="liens">
        
    	<ul>
       		<li><a href="../accueil/index.php">Accueil</a></li>
        	<li><a href="../moncompte/moncompte.php">Mon compte</a></li>
            <li><a href="../projets/projets.php">Community</a></li>
        	<li><a href="../documents/documents.php">Documents</a></li>
        	<li><a href="../etudiants/etudiants.php">Étudiants</a></li>
        	<li><a href="../evenements/evenements.php">Evénements</a></li>
        	<li><a href="../sondages/sondages.php">Sondages</a></li>
       		<li><a href="../entraide/entraide.php">Entraide</a></li>
       		<li><a href="../sbn/">Stages</a></li>
        	<?php if ($_SESSION['user']['status'] == 2) { echo "<li><a href='../administration'>Administration</a></li>"; } ?>
        </ul>
        
    </div>
            <div id="social">
            	<a href="http://twitter.com/#!/SupinfoLille" title="twitter" target="_blank"><img src="../images/twit.png" alt="Twitter" /></a><br />
            	<a href="http://www.facebook.com/group.php?gid=279258064206" title="face" target="_blank"><img src="../images/face.png" alt="Facebook" /></a><br />
            	<a href="https://github.com/Matthieu68857/SupinfoLille" title="github" target="_blank"><img src="../images/git.png" alt="GitHub" /></a>
            </div>
    </div>
    
	</div>
	</div>
 
</body>
</html>
