<?php

return [

    'floors' => [

        1 => [
            'name'    => 'La Tour',
            'image'   => 'Tower.png',
            'type'    => 'intro',
            'answer'  => null,
            'gustave' => [
                ['speaker' => 'gustave', 'text' => "Oh! J'ai cru que t'arriverais jamais! Maman, bienvenue à la Tour. Papa est souvent enfermé là dedans."],
                ['speaker' => 'player', 'text' =>"Tiens, Gustave. Tu m'expliques ce que je fais là ?"],
                ['speaker' => 'gustave', 'text' => "Après tout... Une dragonne doit bien garder sa princesse dans sa tour, non ? ;)"],
                ['speaker' => 'player', 'text' => "Super... On va se faire empaler dans un couloir sombre à regarder son château fort..."],
                ['speaker' => 'gustave', 'text' =>"Haut les coeurs, je me doute que tout se passera très bien ! :D"]
            ],
            'hotspots' => [],
        ],

        2 => [
            'name'    => 'La Bibliothèque',
            'image'   => 'Library.png',
            'type'    => 'book_password',
            'answer'  => 'LIBERTE',
            'gustave' => [
                ['speaker' => 'gustave', 'text' =>"Ah, nous voilà au premier étage ! Papa est comme toi, il adore lire... Enfin, il fait sombre ici, et on dirait que tout est fermé."],
                ['speaker' => 'menacing', 'text' =>"Personne ne pénètrera dans mon coeur ainsi. Seuls les élus qui sauront percer mes secrets pourront résider avec moi."],
                ['speaker' => 'player', 'text' =>"C'était quoi ça ??"],
                ['speaker' => 'gustave', 'text' =>"Des secrets... Papa adore les énigmes, je parie que la porte a un mot clé et qu'il se trouve dans la salle."],

            ],
            'hotspots' => [
                [
                    'id'      => 'book1',
                    'x'       => 30,
                    'y'       => 55,
                    'title'   => 'Jonathan Livingston le Goéland',
                    'author'  => 'Richard Bach',
                    'color'   => '#4a2c6e',
                    'summary' => "Jonathan Livingston n'est pas un goéland comme les autres. Sa seule passion, c'est de voler toujours plus vite et plus haut. Incompris des autres goélands, il est chassé du clan et condamné à une vie solitaire. Jonathan poursuit sa quête de liberté et bientôt, de nouvelles rencontres vont bouleverser son existence.",
                ],
                [
                    'id'      => 'book2',
                    'x'       => 42,
                    'y'       => 52,
                    'title'   => 'Spartacus',
                    'author'  => 'Arthur Koestler',
                    'color'   => '#7a1a1a',
                    'summary' => "71 avant JC. La République romaine, au faîte de sa puissance, se vautre dans la luxure. Les petits paysans, dépossédés de leur terre, encombrent des villes surpeuplées. Les élites ne pensent qu'aux plaisirs. Le sang de l'arène irrigue tous les étages de la société. C'est de cette fange qu'émerge Spartacus : gladiateur révolté et formidable meneur d'hommes. À la tête d'une gigantesque armée d'esclaves, il défie la République. Rejoint par tous les opprimés, les réprouvés, Spartacus se lance dans une fuite éperdue à travers la péninsule. Avec, au bout du chemin, un unique espoir : la liberté.",
                ],
                [
                    'id'      => 'book3',
                    'x'       => 78,
                    'y'       => 55,
                    'title'   => 'Le Petit Prince',
                    'author'  => 'Antoine de Saint-Exupéry',
                    'color'   => '#1a3f6e',
                    'summary' => "« Le premier soir, je me suis donc endormi sur le sable à mille milles de toute terre habitée. J'étais bien plus isolé qu'un naufragé sur un radeau au milieu de l'océan. Alors, vous imaginez ma surprise, au lever du jour, quand une drôle de petite voix m'a réveillé. Elle disait : \"S'il vous plaît... dessine-moi un mouton !\" J'ai bien regardé. Et j'ai vu ce petit bonhomme tout à fait extraordinaire qui me considérait gravement... »",
                ],
            ],
            'hint_hotspot' => ['x' => 55, 'y' => 70],
            'hint_line' => [
                ['speaker' => 'gustave', 'text' => "Jonathan Livingston, Spartacus, Le Petit Prince... Ces trois ouvrages ont forcément un point commun."],
            ],
            'correct_dialogue' => [
                ['speaker' => 'gustave', 'text' =>"Ah mais bien sûr ! la Liberté ! Jonathan Livingston, l'oiseau qui vole pour sentir la liberté, Spartacus, l'esclave qui s'est battu pour sa liberté, et la liberté de l'âme d'enfant du Petit Prince ! Tu es géniale Maman ! :D"],
                ['speaker' => 'menacing', 'text' =>"Alors malgré ma mise en garde tu veux entrer dans mon coeur... Soit. Sache que cette énigme était la plus facile et que tu risques de ne pas aller plus loin, tout Dragon que tu sois."],
                ['speaker' => 'gustave', 'text' =>"Maman, n'abandonne pas ! Tu sais que Papa est très pudique à propos de lui même. C'est l'occasion de mieux le connaitre!"],
            ],
            'password_prompt' => 'Quel mot unit ces trois histoires ?',
        ],

        3 => [
            'name'    => 'La Cuisine',
            'image'   => 'kitchen.jpg',
            'type'    => 'password',
            'answer'  => 'PARTAGE',
            'gustave' => [
                
                ['speaker' => 'gustave', 'text' =>"Wow c'est la cuisine de Papa! Eurk, quel bazar, ça doit te refiler de l'urticaire nan ? "],
                ['speaker' => 'gustave', 'text' =>"Cette recette... C'est les Citrompe-l'oeil, la création de Papa. Mais c'est bizarre, certains mots sont un peu différents."],
                ['speaker' => 'player', 'text' =>"C'est à cause des fautes d'orthographe..."],
                ['speaker' => 'gustave', 'text' =>"Maman, ce truc a forcémement une signification, Papa ne ferait pas ce genre de fautes, il y a forcément une explication."],

            ],
            'hotspots' => [],
            'clue_hotspots' => [
                [
                    'id'  => 'lightbulb',
                    'x'   => 51,
                    'y'   => 30,
                    'clue' => "Hmm... Ces mots qui ont des fautes... Les lettres sont particulières, non ?",
                ],
            ],
            'correct_dialogue' => [
                ['speaker' => 'gustave', 'text' =>"Mais oui, avec la première lettre de chaque mot faute, on obtient PARTAGE! et c'est la manière de Papa de partager avec ceux qu'il aime, la cuisine !"],
                ['speaker' => 'menacing', 'text' =>"Je ne serais pas si enthousiaste. Il reste encore bien des choses à resoudre... et vous n'y arriverez pas."],
                ['speaker' => 'player', 'text' =>"Euh..."],
                ['speaker' => 'gustave', 'text' =>"Quel rabat-joie... Enfin, on y va, on à ouvert l'étage suivant ! C'est partiii~"],
            ],
            'password_prompt' => 'Quel est le mot de passe de cette pièce ?',
        ],

        4 => [
            'name'    => 'La Salle de Musique',
            'image'   => 'MusicPiano.png',
            'type'    => 'password',
            'answer'  => 'EMOTION',
            'gustave' => [
                ['speaker' => 'gustave', 'text' =>"'L'opéra' de Papa. Il aime tellement la musique... D'ailleurs, la pièce qui est en train de jouer est une de ses pièces favorites, la Pavane de Fauré."],
                ['speaker' => 'player', 'text' =>"Gustave, regarde..."],
                ['speaker' => 'gustave', 'text' =>"La partition que tu as reçue ? Bizarre... Il y a des notes qui sont entourées. Voyons voir... Est-ce qu'on peut bien en faire quelque chose ?"],
            ],
            'hotspots' => [],
            'conversion_table' => [
                'x'    => 43,
                'y'    => 60,
                'rows' => [
                    ['note' => 'Do',  'letter' => 'M', 'staff_y' => 30, 'ledger' => true],
                    ['note' => 'Ré',  'letter' => 'I', 'staff_y' => 28, 'ledger' => false],
                    ['note' => 'Mi',  'letter' => 'O', 'staff_y' => 25, 'ledger' => false],
                    ['note' => 'Fa',  'letter' => 'T', 'staff_y' => 22, 'ledger' => false],
                    ['note' => 'Sol', 'letter' => 'E', 'staff_y' => 20, 'ledger' => false],
                    ['note' => 'La',  'letter' => 'N', 'staff_y' => 17, 'ledger' => false],
                    ['note' => 'Si',  'letter' => 'R', 'staff_y' => 15, 'ledger' => false],
                ],
                'clue' => ['speaker' => 'gustave', 'text' =>"Oh ? Un tableau de conversion ? On y voit des notes être associées à des lettres... En quoi est-ce que ça nous aide ?"],
            ],
            'correct_dialogue' => [
                ['speaker' => 'player', 'text' =>"On a réussi !"],
                ['speaker' => 'gustave', 'text' =>"Oh mais t'es trop forte ! En remettant tout dans l'ordre avec les bonnes lettres, on obtient EMOTION! et à l'époque Papa livrait ses émotions à travers la musique !"],
                ['speaker' => 'menacing', 'text' =>"Ce n'est pas vraiment une époque qui est toujours d'actualité... Mais au moins, tu es perspicace. Peut-être que tu vas arriver au bout au final."],
                ['speaker' => 'gustave', 'text' =>"Maman ! Même papa il t'encourage ! ...Enfin presque. Il le cache ce grand timide. Allez !"],
            ],
            'password_prompt' => 'Quel mot résonne dans cette salle ?',
        ],

        5 => [
            'name'    => "La Salle des Athlètes",
            'image'   => 'lockerroom.jpg',
            'type'    => 'digicode',
            'answer'  => '622',
            'gustave' => [
                ['speaker' => 'gustave', 'text' =>"Ah, on est arrivés tellement hauts que nos voix ne paviennent plus à nos oreilles ! Argh !"],
                ['speaker' => 'player', 'text' =>"Gustave, on entend toujours la musique."],
                ['speaker' => 'gustave', 'text' =>"C'est différent la musique..."],
                ['speaker' => 'player', 'text' =>"Nan mais si t'as pas eu le temps de faire toutes les voix c'est pas grave hein..."],
                ['speaker' => 'gustave', 'text' =>"Je ne vois pas du tout de quoi tu veux parler. Bref, on a un digicode... Tu as des indices ?"],
                ['speaker' => 'player', 'text' =>"Seulement un bout de papier à moitié déchiré..."],
                ['speaker' => 'gustave', 'text' =>"Bah super. On va aller loin avec ça."],
            ],
            'hotspots' => [],
            'clue_hotspots' => [
                [
                    'id'    => 'locker-sticker',
                    'x'     => 37,
                    'y'     => 32,
                    'label' => '50m ♥',
                    'clue'  => "50 mètres. C'est la distance. On n'a plus qu'à trouver ce qui la relie à Papa.",
                ],
            ],
            'correct_dialogue' => [
                ['speaker' => 'gustave', 'text' =>"622 pour 6'22, le meilleur temps et les plus beaux souvenirs sportifs de Papa. Fallait la trouver celle là"],
                ['speaker' => 'menacing', 'text' =>"L'Histoire ne retient pas les perdants."],
                ['speaker' => 'player', 'text' =>"Pourtant tu n'as pas oublié cette course puisque tu l'as mise en mot de passe dans ton propre coeur."],
                ['speaker' => 'menacing', 'text' =>"..."],
                ['speaker' => 'menacing', 'text' =>"Tu es arrivée au bout de mes énigmes. Il n'y a plus rien qui te sépare de moi et de mon histoire maintenant."],
                ['speaker' => 'gustave', 'text' =>"Vas-y Maman. Je t'attends ici, vous avez sûrement des choses à vous dire."],
            ],
            'password_prompt' => "Code d'accès",
        ],

        6 => [
            'name'    => 'Les Champs du Sommet',
            'image'   => 'fields.png',
            'type'    => 'finale',
            'answer'  => null,
            'gustave' => [
                ['speaker' => 'beloved', 'text' => "..."],
                ['speaker' => 'beloved', 'text' => "Jade. Mon amour."],
                ['speaker' => 'beloved', 'text' => "Je ne voulais guère me cacher, ni même te faire peur."],
                ['speaker' => 'beloved', 'text' => "Gustave l'a bien dit au départ... Je suis encore ancré au passé. Je n'aime pas trop me livrer comme ça, mais je pense qu'il est important que j'essaie de me montrer à toi"],
                ['speaker' => 'beloved', 'text' => "Tu le sais, j'ai passé de longues années endeuillé, blessé, trahi. Et je ne sais plus faire confiance."],
                ['speaker' => 'beloved', 'text' => "Il me fallait un moyen d'être sûr que tu m'aimerais pour qui j'ai été, qui je suis et qui je serai. Mettre des énigmes dans cette tour était un bon moyen."],
                ['speaker' => 'beloved', 'text' => "Ce n'était pas impossible à résoudre je le sais, mais suffisamment décourageant pour quiconque n'aurait pas la volonté d'apprendre à me connaitre un peu. "],
                ['speaker' => 'beloved', 'text' => "Je dois te laisser."],
                ['speaker' => 'beloved', 'text' => "Je t'ai laissé une derniere enveloppe, avec une lettre qui aura le même contenu que celle qui va s'afficher."],
                ['speaker' => 'beloved', 'text' => "Je t'aime fort. A bientôt, ma bien-aimée."],
            ],
            'hotspots' => [],
            'finale_bg'  => 'Foolmoonnight.jpg',
            'love_letter' => "Mon amour. \n\nToute ma vie, je t'ai cherchée, mais c'est au moment le plus innattendu que je t'ai trouvée.\nJe ne trouvais plus de goût à la vie, ni aux activités diverses que tu as pu voir dans ma tour.
            Mais quand tu as honoré ma vie de ta présence divine, le 30 décembre 2025, alors j'ai eu un sentiment étonnant. Certes, rien qui ne s'apparentait à un amour inconditionnel, mais j'ai senti une étonnante pique dans mon coeur.\n
            Evidemment, cette petite pique, je l'ai d'abord ignorée, et j'ai même eu un léger ressentimment envers toi, parce que tu m'avais fait sortir de mon anhédonie habituelle. Je me disais \"Adrien, tu ne ressens rien pour personne et ce n'est pas maintenant que tu vas recommencer.\" 
            Alors je t'ai ignorée, les premiers jours, jusqu'à ce que je vienne discuter avec toi par vocaux discord. Une drôle de sensation m'a rempli. Je n'avais plus ce ressentiment que j'ai eu initialement, mais j'ai plutôt trouvé ta présence très agréable.\n
            Je me suis autorisé alors, à considérer que tu puisses être une amie. Que je puisse travailler avec toi, et m'inspirer de ton énergie solaire pour me projeter moi même plus haut. J'ai cette habitude depuis longtemps, d'absorber l'énergie des autres pour leur voler et la mettre à mon profit.
            C'est perfide, méchant, voir même égoiste, mais dans notre monde, je n'avais plus vraiment de remords à utiliser les autres. Mais, au fur et à mesure que je comptais utiliser ta présence pour me tirer vers le haut, j'ai découvert une personne bien plus sensible et blessée que je le pensais.\n
            Au départ, je n'ai fait qu'écouter, répondre, découvrir, écouter à nouveau... Mais plus on avançait, plus je me reconnaissais à quelques années d'intervalles. Je me suis senti comme un grand frère et ai voulu t'éviter de sombrer comme j'ai pu le faire.\n
            Loin de moi l'idée de te prendre en pitié. Je n'ai fait que t'écouter et réagir humainement, ce que je ne faisais plus vraiment depuis un certain temps. Et à force des vocaux, de cette envie de te préserver, de garder cette énergie rare, cette fille brillante... J'ai fini par réaliser que mes pensées
            étaient en train d'évoluer. On est passés de léger ressentiment, à amis, à quasiment frère et soeur dans ma manière de voir les choses. Cette évolution, excessivement rapide et agréable, m'a fait peur. J'ai eu peur de tomber amoureux à terme, et vu la tournure des choses,
            ça arrivait à grande allure.\n 
            Dans ma conscience, ma vie amoureuse était terminée depuis longtemps, et je ne voulais plus revenir dessus. Il m'a fallu faire un pas en arrière, prendre le temps de réfléchir, et savoir ce que je devais faire. 
            La réflexion a pris fin, et j'ai accepté mon sort : ta personne avait déjà envahi mon coeur et réchauffé les lieux de ton souffle draconique. Tu m'as bougé, mis sens dessus dessous.\n
            Alors, à ce moment là, mi-février, j'ai voulu me lancer... Et j'ai cru me prendre un stop. J'ai été terrifié. Tu m'as dit ne pas être prête, ne pas être sûre... Alors j'ai cru que je te perdais.\n
            Les deux semaines suivantes ont été un peu dures ; est-ce que je devais continuer le flirt ? Arrêter et abandonner ? Je n'en avais aucune idée et j'étais dans le brouillard... Jusqu'au 27. Je me permets ce jour là de t'envoyer
            un réel, où je demande si je peux 'call you mine'. Et alors, la destinée arrive... Et je n'ai plus qu'à t'aimer, pour toute ma vie durant. Peu importe les vagues et les tempêtes, je ne suis qu'un petit pêcheur farouche qui veut arriver à bon port.
            \n\n Tu l'as compris, je t'aime de manière inconditionnelle, à la folie, sans jamais penser aux conséquences, et je veux être celui qui te rend heureuse jusqu'à la fin de nos vies.
            \n Ton Amoureux."
        ],

    ],

];
