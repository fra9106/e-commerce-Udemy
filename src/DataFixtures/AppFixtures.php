<?php

namespace App\DataFixtures;

use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
        public function load(ObjectManager $manager)
        {
        $category1 = new Category();
        $category1->setName("Bonnets");

        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName("Montres");

        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName("Bijoux");

        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName("Portables");

        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName("Drones");

        $manager->persist($category5);

        $category6 = new Category();
        $category6->setName("Electro-ménager");

        $manager->persist($category6);

        $product = new Product();
        $product->addCategory($category1);
        $product->setName("Chapeau d'hiver pour femmes")
                ->setDescription("Chapeau d'hiver pour femmes, chapeau en velours, épais, chaud, bonnet en tricot Chenille, chapeau d'équitation, 2 casquettes en laine")
                ->setPrice(6999)
                ->setIsBest(1)
                ->setImage('bonnet_femme_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category1);
        $product->setName("Bonnet tricoté pour femmes")
                ->setDescription("Bonnets tricoté pour femmes, Bonnet de marque, épais et chaud, tête de mort en tricot, lettre, Bonnet, ensembles d'équitation en plein air")
                ->setPrice(3999)
                ->setIsFeatured(1)
                ->setImage('bonnet_femme_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category1);
        $product->setName("Chapeaux en laine de velours pour femmes")
                ->setDescription("Chapeaux en laine de velours pour femmes, bonnet torsadé, bonnet assorti, tête de cheval, tricoté, vente en gros, nouveau hiver")
                ->setPrice(4999)
                ->setIsNewArrival(1)
                ->setImage('bonnet_femme_3.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);
        
        $product = new Product();
        $product->addCategory($category1);
        $product->setName("Chapeaux en laine pour femmes")
                ->setDescription("Chapeau en laine pour femmes, Bonnet, Patch épais et chaud, Bonnet tricoté multicolore, pour l'hiver")
                ->setPrice(7999)
                ->setIsSpecialOffer(1)
                ->setImage('bonnet_femme_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);
        
        $product = new Product();
        $product->addCategory($category2);
        $product->setName("Montre intelligente femmes")
                ->setDescription("Montre intelligente hommes femmes Smartwatch fréquence cardiaque moniteur de pression artérielle Fitness Tracker Bracelet de Sport intelligent pour Android IOS")
                ->setPrice(57999)
                ->setIsBest(1)
                ->setImage('montre_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category2);
        $product->setName("Montre intelligente hommes")
                ->setDescription("Montre intelligente hommes femmes 1.6 plein écran tactile Bluetooth appel Smartwatch fréquence cardiaque tensiomètre pour Android et IOS")
                ->setPrice(87999)
                ->setIsFeatured(1)
                ->setImage('montre_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category2);
        $product->setName("Bracelet intelligent")
                ->setDescription("Plus étanche montre intelligente Sport Bracelet intelligent fréquence cardiaque moniteur de pression artérielle Fitness Tracker pour Android et IOS")
                ->setPrice(35990)
                ->setIsSpecialOffer(1)
                ->setImage('montre_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category3);
        $product->setName("Mode en acier inoxydable")
                ->setDescription("Nouvelle mode en acier inoxydable bande lettre étoile lune oeil paume pendentif collier pour femmes charme femelle CZ bijoux cadeau")
                ->setPrice(22990)
                ->setIsBest(1)
                ->setImage('bijou_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category3);
        $product->setName("Collier en acier inoxydable")
                ->setDescription("Collier pendentif Vintage en acier inoxydable pour femmes, étoile de lune, breloque or, bijou CZ")
                ->setPrice(54990)
                ->setIsFeatured(1)
                ->setImage('bijou_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category3);
        $product->setName("Chaîne en cuivre plaqué or")
                ->setDescription("Mode en acier inoxydable chaîne en cuivre plaqué or carré coeur pendentif collier pour les femmes charme femme pleine CZ bijoux collier")
                ->setPrice(14990)
                ->setIsSpecialOffer(1)
                ->setImage('bijou_3.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category3);
        $product->setName("Acier inoxydable irrégulière")
                ->setDescription("Chaîne mode en acier inoxydable irrégulière chaîne en cuivre plaqué or carré coeur pendentif collier pour les femmes charme femme pleine CZ bijoux collier")
                ->setPrice(18990)
                ->setIsNewArrival(1)
                ->setImage('bijou_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category4);
        $product->setName("Débloqué Apple Original iPhone XS")
                ->setDescription("IPhone X aucune identification de visage. Cela signifie que le téléphone n'a pas de fonction face ID. Vous ne pouvez déverrouiller le téléphone qu'en définissant le mot de passe dans le téléphone. Et d'autres fonctions du téléphone fonctionnent complètement bien, si cela vous dérange, veuillez choisir iPhone X avec Face ID.")
                ->setPrice(88990)
                ->setIsBest(1)
                ->setImage('portable_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category4);
        $product->setName("Débloqué Apple iPhone XR Original 4G")
                ->setDescription("Débloqué Apple iPhone XR Original 4G iOS rétine liquide entièrement écran LCD 12MP 6.1 \"64GB/128GB/256GB visage ID Smartphones utilisés")
                ->setPrice(98990)
                ->setIsFeatured(1)
                ->setImage('portable_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category4);
        $product->setName("Débloqué Original Apple iPhone X")
                ->setDescription("Débloqué Original Apple iPhone X Hexa Core Face ID 256GB/64GB ROM 3GB RAM double caméra arrière 12MP 5.8 \"4G LTE Smartphones")
                ->setPrice(128990)
                ->setIsNewArrival(1)
                ->setImage('portable_3.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category4);
        $product->setName("Téléphone portable d'origine débloqué")
                ->setDescription("Téléphone portable d'origine débloqué Apple iPhone X Hexa Core 256GB/64GB ROM 3GB RAM double caméra arrière 12MP 5.8 \"4G LTE Smartphone")
                ->setPrice(148990)
                ->setIsSpecialOffer(1)
                ->setImage('portable_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category5);
        $product->setName("TUCCI 2020 nouveau Mini Drone 4K")
                ->setDescription("TUCCI 2020 nouveau Mini Drone 4K 1080P HD caméra WiFi Fpv pression d'air Altitude tenir pliable quadrirotor RC Drone enfant jouet cadeau")
                ->setPrice(5990)
                ->setIsBest(1)
                ->setImage('drone_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category5);
        $product->setName("Aéronef sans pilote (UAV)")
                ->setDescription("Aéronef sans pilote (UAV) Quadrocopter drone rc avec caméra 4K professionnel WIFI photographie aérienne grand Angle jouet télécommandé Ultra-longue durée")
                ->setPrice(9990)
                ->setIsFeatured(1)
                ->setImage('drone_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category5);
        $product->setName("Nouveau Mini Drone 4K, TUCCI 2021")
                ->setDescription("TUCCI 2020 nouveau Mini Drone 4K 1080P HD caméra WiFi Fpv pression d'air Altitude tenir pliable quadrirotor RC Drone enfant jouet cadeau")
                ->setPrice(19990)
                ->setImage('drone_3.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category5);
        $product->setName("Nouveau Mini Drone XT6 8K 5080P HD")
                ->setDescription("TUCCI 2020 nouveau Mini Drone 4K 1080P HD caméra WiFi Fpv pression d'air Altitude tenir pliable quadrirotor RC Drone enfant jouet cadeau")
                ->setPrice(37990)
                ->setIsSpecialOffer(1)
                ->setImage('drone_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category5);
        $product->setName("Nouveau Mini Drone XT6 8K 1080P HD")
                ->setDescription("Nouveau Mini Drone XT6 4K 1080P HD caméra WiFi Fpv pression d'air Altitude tenir pliable quadrirotor RC Drone enfant jouet cadeau")
                ->setPrice(18990)
                ->setIsNewArrival(1)
                ->setImage('drone_5.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category6);
        $product->setName("Coupe-légumes multifonctionnel")
                ->setDescription("coupe-légumes multifonctionnel rond mandoline trancheuse pomme de terre fromage cuisine machine radis déchiqueteuse cuisine tambour hacher artefact petits accessoires accessoires de cuisine")
                ->setPrice(5990)
                ->setIsBest(1)
                ->setImage('gadget_1.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category6);
        $product->setName("Éplucheur de légumes multifonction")
                ->setDescription("Éplucheur de légumes multifonction en acier inoxydable et coupeur ampJulienne Julienne éplucheur de pommes de terre carotte râpe outil de cuisine")
                ->setPrice(8990)
                ->setIsFeatured(1)
                ->setImage('gadget_2.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category6);
        $product->setName("Crêpière Antiadhésive Ensemble De Marmite")
                ->setDescription("Crêpière Antiadhésive Ensemble De Marmite à Quatre trous Poêle À Frire Poêle Crêpe D'oeuf Steak Épaissi Omelette Maker Ustensiles De Cuisine")
                ->setPrice(6990)
                ->setImage('gadget_3.png')
                ->setIsSpecialOffer(1)
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $product = new Product();
        $product->addCategory($category6);
        $product->setName("Trancheuse de légumes multifonctionnelle")
                ->setDescription("Trancheuse de légumes multifonctionnelle éplucheur de pommes de terre ail mouture carotte oignon râpe avec crépine accessoires de cuisine outil de légumes")
                ->setPrice(2990)
                ->setIsNewArrival(1)
                ->setImage('gadget_4.png')
                ->setQuantity(50)
                ->setCreatedAt(new \DateTime());

        $manager->persist($product);

        $carrier1 = new Carrier;

        $carrier1->setName('UPS')
                ->setDescription('Ouvert du lundi au Samedi')
                ->setPrice(7000)
                ->setCreatedAt(new \DateTime());

        $manager->persist($carrier1);

        $carrier2 = new Carrier;

        $carrier2->setName('ChronoPost')
                ->setDescription('Ouvert du lundi au Samedi')
                ->setPrice(5000)
                ->setCreatedAt(new \DateTime());
                

        $manager->persist($carrier2);

        $carrier3 = new Carrier;

        $carrier3->setName('Colissimo')
                ->setDescription('Ouvert du lundi au Samedi')
                ->setPrice(3000)
                ->setCreatedAt(new \DateTime());

        $manager->persist($carrier3);


        $manager->flush();
        }
}
