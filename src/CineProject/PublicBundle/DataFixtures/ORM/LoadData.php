<?php

namespace AppBundle\DataFixtures\ORM;

use CineProject\PublicBundle\Entity\Actor;
use CineProject\PublicBundle\Entity\Movie;
use CineProject\PublicBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		for ($i = 1; $i <= 10; $i++) {
			$movie = new Movie();
			$movie->setTitle("Pulp fiction $i");
			$movie->setDescription(
				"Interdit aux moins de 12 ans
				L'odyssée sanglante et burlesque de petits malfrats dans la jungle de Hollywood à travers trois histoires qui s'entremêlent.
				");
			$releaseDate = new \DateTime( '1994/10/26' );
			$movie->setReleaseDate($releaseDate);
			$movie->setVisible(true);
			$manager->persist($movie);
		}

		for ($i = 1; $i <= 10; $i++) {
			$actor = new Actor();
			$actor->setFirstName('Uma');
			$actor->setLastName("Thurman $i");
			$birthDate = new \DateTime( '1970/04/29' );
			$actor->setBirthDate($birthDate);
			$actor->setBiography(
				"Née à Boston, Uma Thurman grandit à Ameherst, dans le Massachusetts. Remarquée à quinze ans par deux impresarios new-yorkais dans une école préparatoire de Nouvelle-Angleterre, elle rejoint un an plus tard la Professional Children's School pour embrasser la carrière de comédienne. Elle tient son premier rôle en 1988 dans Johnny be good de Bud Smith, face à Anthony Michael Hall. La même année, elle s'impose dans deux succès internationaux : Les Aventures du baron de Munchausen de Terry Gilliam, où elle incarne une juvénile et pulpeuse Vénus, et Les Liaisons dangereuses de Stephen Frears.

				Suivent sa performance d'épouse névrosée et bisexuelle dans Henry & June (1990) de Philip Kaufman et d'autres seconds rôles remarqués qui confirment ses talents de comédienne : patiente psychotique de Richard Gere dans Sang chaud pour meurtre de sang-froid (1992), témoin aveugle dans Jennifer 8 (id.), prostituée au grand coeur de Robert De Niro dans Mad dog and glory (1993) ou encore auto-stoppeuse hippie au pouce démesuré dans l'excentrique Even cowgirls get the blues (id.) de Gus Van Sant. 1994 est l'année de la consécration : Uma Thurman se retrouve en tête d'affiche du cultissime Pulp fiction de Quentin Tarantino, Palme d'Or au Festival de Cannes. Son rôle de pseudo-actrice junkie victime d'une overdose lui vaut d'être citée à l'Oscar du Meilleur second rôle féminin.

			Après la comédie romantique Entre chiens et chats (1996), elle assoit définitivement son sex appeal à Hollywood en prêtant ses traits à la vénéneuse Poison Ivy dans Batman & Robin (1997) et en revêtant la très moulante tenue d'Emma Peel dans l'adaptation cinématographique de la série Chapeau melon et bottes de cuir (1998). Donnant la réplique à son compagnon à la ville de l'époque, Ethan Hawke, dans le futuriste Bienvenue à Gattaca (1998), elle tourne sous la direction de Woody Allen dans Accords et désaccords (1999) et se montre également à l'aise dans des fresques littéraires (Les Misérables 1998) et des films d'époque comme Vatel (2000) de Roland Joffé et La Coupe d'or (id.) de James Ivory.

			Deux ans plus tard, Uma Thurman s'entraîne durement aux arts martiaux pour le tournage du tonitruant diptyque Kill Bill (2003 et 2004), une sanglante histoire de vengeance qui marque sa seconde collaboration avec Quentin Tarantino, et par la même occasion l'une de ses prestations les plus marquantes. De retrouvailles, il en est également question pour Be cool (2005), la suite de Get shorty, la belle se déhanchant à nouveau aux côtés de John Travolta, son partenaire de danse dans l'inoubliable Pulp fiction.

L'après Kill Bill est plutôt dur pour la comédienne, qui a du mal à trouver des rôles intéressants. De plus, ses films sont souvent des échecs commerciaux, notamment Ma super ex (2006) et Maman mode d'emploi (2009). Cependant, elle a l'occasion de donner la réplique aux oscarisés Meryl Streep (Petites confidences (à ma psy), 2006) et Colin Firth (Un mari de trop, 2008), tout en faisant tourner la tête des Producteurs Nathan Lane et Matthew Broderick dans le remake de la désopilante comédie de Mel Brooks. On peut également l'apercevoir en Méduse, en 2010, dans Percy Jackson le voleur de foudre, premier volet d'une énième saga destinée aux adolescents.

			Si les bons rôles se font toujours rares, Uma Thurman fait partie du jury de Robert De Niro pour la 64ème édition du Festival de Cannes, un statut témoignant de la qualité de sa carrière. De moins en mois présente sur grand écran, la comédienne effectue ses premiers pas à la télévision, en 2012, dans la série Smash. Elle y incarne, le temps de cinq épisodes, une starlette qui décroche le rôle de Marilyn Monroe dans une production de Broadway centrée sur la fameuse star. La même année, on la retrouve, au cinéma, en Madeleine Forestier, l'une des conquêtes du Bel Ami Robert Pattinson, dans un long métrage adapté du célèbre roman de Guy de Maupassant."
			);
			$actor->setSlug("uma-thurman-$i");
			$manager->persist($actor);
		}

		/**/ // users
		$user = new User();
		$user->setUsername('admin');
		$user->setEmail('email1@domain.com');
		$user->setPlainPassword('admin');
		$user->setEnabled(true);
		$user->setRoles(array('ROLE_ADMIN'));
        $manager->persist($user);

		$user = new User();
		$user->setUsername('user');
		$user->setEmail('email2@domain.com');
		$user->setPlainPassword('user');
		$user->setEnabled(true);;
		$manager->persist($user);
		/*/*/

		$manager->flush();
	}
}