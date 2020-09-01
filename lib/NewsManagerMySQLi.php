<?php
class NewsManagerMySQLi extends NewsManagerMySQLi
{
	/*Attribut contenant l'instance représentant la BDD
	@type MySQLi
	*/
	protected $db;
	
	/*Constructeur étant chargé d'enregistrer l'instance de MySQLi dans l'attribut $db
	@param $db MySQLi Le DAO
	*/
	public function __construct(MySQLi $db)
	{
		$this->db = $db;
	}
	
	/*
	@see NewsManager::add()
	*/
	protected function add(News $news)
	{
		$requete = $this->db->prepare('INSERT INTO news(auteur, titre, contenu, detaAjout, dateModif)
										VALUES(?, ?, ?, NOW(), NOW())');
										
		$requete->bind_param('sss', $news->auteur(), $news->titre(), $news->contenu());
		
		$requete->execute();
	}
	
	/*
	@see NewsManager::count()
	*/
	public function count()
	{
		return $this->db->query('SELECT id FROM news')->num_rows;
	}
	
	/*
	@see NewsManager::delete()
	*/
	public function delele()
	{
		$id= (int) $id;
		$requete = $this->db->prepare('DELETE FROM news WHERE id = ?');
		$requete->bind_param('i', $id);
		$requete->execute();
	}
	
	/*
	@see NewsManager::getList()
	*/
	public function getList($debut = -1, $limite = -1)
	{
		$listeNews = [];
		$sql = 'SELECT id, auteur, titre, contenu, dateAjout, dateModif
				FROM news ORDER BY id DESC';
				
		//on vérifie l'intégrité des paramètres fournis
		if($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}
		$requete = $this->db->query($sql);
		
		while($news = $requete->fetch_object('News'))
		{
			$news->setDateAjout(new DateTime($news->dateAjout()));
			$news->setDateModif(new DateTime($news->dateModif()));
			
			$listeNews[] = $news;
		}
		
		return $listeNews;
		
	}
	
	
	/*
	@see NewsManager::getUnique()
	*/
	public function getUnique($id)
	{
		$id = (int) $id;
		
		$requete = $this->db->prepare('SELECT id, auteur, titre, contenu, dateAjout, dateModif
										FROM news WHERE id = ?');
		$requete->bind_param('id', $id);
		$requete->execute();
		
		$requete->bind_result($id, $auteur, $titre, $contenu, $dateAjout, $dateModif);
		
		$requete->fetch();
		
		return new News([
		'id' => $id,
		'auteur' => $auteur,
		'titre' => $titre,
		'contenu' => $contenu, 
		'dateAjout' => new DateTime($dateAjout),
		'dateModif' => new DateTime($dateModif)
		]);
	}
	
	/*
	@see NewsManager::update()
	*/
	
	protected function update(News $news)
	{
		$requete = $this->db->prepare('UPDATE news SET auteur = ?, titre = ?, contenu = ?, dateModif = NOW() WHERE id = ?');
		$requete->bind_param('sssi', $news->auteur(), $news->titre(), $news->contenu(), $news->id());
		$requete->execute();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}