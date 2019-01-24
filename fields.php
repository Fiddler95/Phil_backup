<?php
/**
 * Created by PhpStorm.
 * User: Marco
 * Date: 14/05/2018
 * Time: 22:16
 *
 * vari campi utili nel sistema
 */

$generalFields = [
    0=> 'Computer Science' ,
    1=> 'Physics' ,
    2=> 'Mathematics' ,
    3=> 'Chemistry' ,
    4=> 'Law' ,
    5=> 'Politics' ,
    6=> 'History' ,
    7=> 'Arts' ,
    8=> 'Linguistics' ,
    9=> 'Engineering' ,
    10=> 'Medical Sciences' ];

$philOptions = [
    0 => "I know nothing" ,
    1 => "I have basic knowledge",
    2 => "I took an exam on the subject",
    3 => "I took an exam and studied this topic in depth",
    4 => "I wrote/am writing a thesis or a paper on the subject"];

$genOptions = [
    0 => "I know nothing" ,
    1 => "I have basic knowledge",
    2 => "I took an exam on the subject"];

$tipologiaOptions = [
    0 => "University Lesson" ,
    1 => "Non-University Lesson",
    2 => "Conference/Talk",
    3 => "Introduction/Tutorial",
    4 => "Seminary",
    5 => "Cartoon",
    6 => "Interview/Conversation",
    7 => "Documentary/Biography",
    8 => "Audio only"
];

$authors_list = [
    1=>"Peter Abelard",
    2=>"Alfarabius",
    3=>"Algazel",
    4=>"Alkindus",
    5=>"Albertus de Saxonia",
    6=>"Albertus Magnus",
    7=>"Jean d Alembert",
    8=>"William Alston",
    9=>"Anaxagoras of Clazomenae",
    10=>"Anaximander of Miletus",
    11=>"Anaximenes of Miletus",
    12=>"Elizabeth Anscombe",
    13=>"Anselm of Canterbury",
    14=>"Apollonius of Tyana",
    15=>"Kwame Anthony Appiah",
    16=>"Thomas Aquinas",
    17=>"Aristotle",
    18=>"Antoine Arnauld",
    19=>"Augustine of Hippo",
    20=>"John Langshaw Austin",
    21=>"Averroës",
    22=>"Avicenna",
    23=>"A.J. Ayer",
    24=>"Francis Bacon",
    25=>"Roger Bacon",
    26=>"Pierre Bayle",
    27=>"Jeremy Bentham",
    28=>"George Berkeley",
    29=>"Isaiah Berlin",
    30=>"Anicius Boethius",
    31=>"Jacob Böhme",
    32=>"F.H. Bradley",
    33=>"C.D. Broad",
    34=>"Thomas Browne",
    35=>"Jean Buridan",
    36=>"Edmund Burke",
    37=>"Joseph Butler",
    38=>"Girolamo Cardano",
    39=>"Rudolf Carnap",
    40=>"Noam Chomsky",
    41=>"Alonzo Church",
    42=>"Catharine Cockburn",
    43=>"R.G. Collingwood",
    44=>"Auguste Comte",
    45=>"Anne Conway",
    46=>"Ralph Cudworth",
    47=>"Donald Davidson",
    48=>"Democritus of Abdera",
    49=>"René Descartes",
    50=>"John Dewey",
    51=>"Denis Diderot",
    52=>"Diogenes of Sinope",
    53=>"Charles Dodgson (Lewis Carroll)",
    54=>"Michael Dummett",
    55=>"John Duns Scotus",
    56=>"R.W Emerson",
    57=>"Epictetus",
    58=>"Epicurus",
    59=>"John Scotus Erigena",
    60=>"Gareth Evans",
    61=>"Feng Youlan",
    62=>"Paul Feyerabend",
    63=>"Johann Fichte",
    64=>"Philippa Foot",
    65=>"Bas van Fraassen",
    66=>"Gottlob Frege",
    67=>"R. Buckminster Fuller",
    68=>"Pierre Gassendi",
    69=>"Ernest Gellner",
    70=>"Nelson Goodman",
    71=>"Gregory of Nyssa",
    72=>"Robert Grosseteste",
    73=>"Susan Haack",
    74=>"Han Fei-zi",
    75=>"R.M. Hare",
    76=>"Friedrich Hayek",
    77=>"G.W.F. Hegel",
    78=>"Martin Heidegger",
    79=>"Hippocrates of Chios",
    80=>"Thomas Hobbes",
    81=>"Ted Honderich",
    82=>"David Hume",
    83=>"Edmund Husserl",
    84=>"Hypatia of Alexandria",
    85=>"Allama Iqbal",
    86=>"William James",
    87=>"Immanuel Kant",
    88=>"Søren Kierkegaard",
    89=>"Christine Korsgaard",
    90=>"Saul Kripke",
    91=>"T.S. Kuhn",
    92=>"K'ung Fu-zi (Confucius)",
    93=>"Imre Lakatos",
    94=>"Lao-zi",
    95=>"Gottfried Leibniz",
    96=>"David Lewis",
    97=>"Alain Locke",
    98=>"John Locke",
    99=>"Peter Lombard",
    100=>"Bernard Lonergan",
    101=>"Lucretius",
    102=>"Ernst Mach",
    103=>"Niccolò Machiavelli",
    104=>"John McDowell",
    105=>"J.L. Mackie",
    106=>"John Macmurray",
    107=>"J.E. McTaggart",
    108=>"Moses ben Maimon (Maimonides)",
    109=>"Nicolas Malebranche",
    110=>"Ernst Mally",
    111=>"Ruth Barcan Marcus",
    112=>"Harriet Martineau",
    113=>"Damaris Masham",
    114=>"Alexius von Meinong",
    115=>"Meng-zi (Mencius)",
    116=>"Marin Mersenne",
    117=>"J.O. de la Mettrie",
    118=>"Mary Midgley",
    119=>"H.T. Mill",
    120=>"J.S. Mill",
    121=>"Mo-zi",
    122=>"Michel de Montaigne",
    123=>"Baron de Montesquieu",
    124=>"G.E. Moore",
    125=>"Thomas Nagel",
    126=>"Nāgārjuna",
    127=>"Nicholas of Autrecourt",
    128=>"Nicholas of Cusa",
    129=>"Jean Nicod",
    130=>"Robert Nozick",
    131=>"Friedrich Nietzsche",
    132=>"William of Ockham",
    133=>"Parmenides of Elea",
    134=>"Blaise Pascal",
    135=>"C.S. Peirce",
    136=>"Philo of Alexandria",
    137=>"Alvin Plantinga",
    138=>"Plato",
    139=>"Plotinus",
    140=>"Protagoras of Abdera",
    141=>"Karl Popper",
    142=>"A.N. Prior",
    143=>"Hilary Putnam",
    144=>"Pyrrho of Elis",
    145=>"Pythagoras of Samos",
    146=>"W.v.O. Quine",
    147=>"Sarvepali Radhakrishnan",
    148=>"Rāmānuja",
    149=>"Ayn Rand",
    150=>"John Rawls",
    151=>"Thomas Reid",
    152=>"Jean-Jacques Rousseau",
    153=>"Bertrand Russell",
    154=>"Gilbert Ryle",
    155=>"Adi Śańkara",
    156=>"Jean-Paul Sartre",
    157=>"Arthur Schopenhauer",
    158=>"Alfred Schütz",
    159=>"J.R. Searle",
    160=>"Wilfrid Sellars",
    161=>"Sextus Empiricus",
    162=>"Henry Sidgwick",
    163=>"Peter Singer",
    164=>"Socrates",
    165=>"Baruch Spinoza",
    166=>"L. Susan Stebbing",
    167=>"P.F. Strawson",
    168=>"Francisco Suárez",
    169=>"Thalēs of Miletus",
    170=>"Judith Jarvis Thomson",
    171=>"Alan Turing",
    172=>"Pierre-Marie Ventre",
    173=>"Giambattista Vico",
    174=>"Voltaire",
    175=>"Wang Ch'ung",
    176=>"Wang Fu-zi (Wang Ch'uan-shan)",
    177=>"Simone Weil",
    178=>"Lady Welby-Gregory",
    179=>"A.N. Whitehead",
    180=>"Bernard Williams",
    181=>"Ludwig Wittgenstein",
    182=>"Mary Wollstonecraft",
    183=>"Chauncey Wright",
    184=>"Xun-zi (Xun Kuang)",
    185=>"Zeno of Elea",
    186=>"Zeno of Kition",
    187=>"Zhu Xi (Chu Yüan-Hui)",
    188=>"Zhuang-ziSarvepali Radhakrishnan",
    189=>"Rāmānuja",
    190=>"Ayn Rand",
    191=>"John Rawls",
    192=>"Thomas Reid",
    193=>"Jean-Jacques Rousseau",
    194=>"Bertrand Russell",
    195=>"Gilbert Ryle",
    196=>"Adi Śańkara",
    197=>"Jean-Paul Sartre",
    198=>"Arthur Schopenhauer",
    199=>"Alfred Schütz",
    200=>"J.R. Searle",
    201=>"Wilfrid Sellars",
    202=>"Sextus Empiricus",
    203=>"Henry Sidgwick",
    204=>"Peter Singer",
    205=>"Socrates",
    206=>"Baruch Spinoza",
    207=>"L. Susan Stebbing",
    208=>"P.F. Strawson",
    209=>"Francisco Suárez",
    210=>"Thalēs of Miletus",
    211=>"Judith Jarvis Thomson",
    212=>"Alan Turing",
    213=>"Pierre-Marie Ventre",
    214=>"Giambattista Vico",
    215=>"Voltaire",
    216=>"Wang Ch'ung",
    217=>"Wang Fu-zi (Wang Ch'uan-shan)",
    218=>"Simone Weil",
    219=>"Lady Welby-Gregory",
    220=>"A.N. Whitehead",
    221=>"Bernard Williams",
    222=>"Ludwig Wittgenstein",
    223=>"Mary Wollstonecraft",
    224=>"Chauncey Wright",
    225=>"Xun-zi (Xun Kuang)",
    226=>"Zeno of Elea",
    227=>"Zeno of Kition",
    228=>"Zhu Xi (Chu Yüan-Hui)",
    229=>"Zhuang-zi"
];

$universities_list =[
    0=>"California Institute of Technology (CALTEC)",
    1=>"Carnegie Mellon University",
    2=>"Central European Unviersity at Budapest",
    3=>"Columbia University",
    4=>"Cornell University",
    5=>"Duke University",
    6=>"Ecole Normale Superieure (Paris)",
    7=>"Georgia Institute of Technology",
    8=>"Harvard University",
    9=>"The Hebrew University of Jerusalem",
    10=>"Italian Institute of Technology (IIT)",
    11=>"The Johns Hopkins University",
    12=>"King's College London",
    13=>"Kyoto University",
    14=>"Imperial College London",
    15=>"London School of Economics (LSE)",
    16=>"Massachusetts Institute of Technology",
    17=>"McGill University",
    18=>"Northwestern University (Chicago)",
    19=>"Ohio State University",
    20=>"Pennsylvania State University",
    21=>"Pierre and Marie Curie University in Paris",
    22=>"Princeton University",
    23=>"Rockefeller University",
    24=>"Rutgers University",
    25=>"Stanford University",
    26=>"Technical University of MŸnchen",
    27=>"University College London",
    28=>"University of Abedeen",
    29=>"University of Amsterdam ",
    30=>"University of Arizona at Tucson",
    31=>"University of Barcelona",
    32=>"University of Basel",
    33=>"University of Berlin (Humboldt)",
    34=>"University of Belrin (Freie Univ.)",
    35=>"University of Bonn",
    36=>"University of Boston",
    37=>"University of Bristol",
    38=>"University of British Columbia",
    39=>"University of Cambridge",
    40=>"University of Campinas",
    41=>"University of California, Berkeley",
    42=>"University of California, Davis",
    43=>"University of California, Irvine",
    44=>"University of California, Los Angeles (UCLA)",
    45=>"University of California, San Diego",
    46=>"University of California, San Francisco",
    47=>"University of California, Santa Barbara",
    48=>"University of Chicago",
    49=>"University of Colorado at Boulder",
    50=>"University of Copenhagen",
    51=>"University of Cork",
    52=>"University of Dublin",
    53=>"University of Durham",
    54=>"University of Edinburgh",
    55=>"University of GenŽve ",
    56=>"University of Genova ",
    57=>"University of Ghent",
    58=>"University of Gršningen",
    59=>"University of Heidelberg",
    60=>"University of Helsinki",
    61=>"University of Hong Kong",
    62=>"University of Konstanz",
    63=>"University of Krakow (Jagellonian Univ.)",
    64=>"University of Illinois at Urbana-Champaign",
    65=>"University of Leeds",
    66=>"University of Leida",
    67=>"University of Leipzig",
    68=>"University of Leuven (Lovanio)",
    69=>"University of Macao",
    70=>"University of Madrid (UNED)",
    71=>"University of Manchester",
    72=>"University of Melbourne",
    73=>"University of Michigan",
    74=>"University of Milano-Bicocca",
    75=>"University of Milano-Cattolica",
    76=>"University of Milano-San Raffaele",
    77=>"University of Milano-Statale",
    78=>"University of Minnesota",
    79=>"University of Montreal",
    80=>"University of Moscow (State University)",
    81=>"University of Munich",
    82=>"University of New York (NYU)",
    83=>"University of New York (Central: CUNY)",
    84=>"University of North Carolina at Chapel Hill",
    85=>"University of Oxford",
    86=>"University of Oslo",
    87=>"University of Paris I -Sorbonne",
    88=>"University of Paris IV Sorbonne",
    89=>"University of Paris VIII Saint Denis",
    90=>"University of Paris X Nanterre",
    91=>"University of Pittsburgh",
    92=>"University of Maryland, College Park",
    93=>"University of Melbourne",
    94=>"University of Pennsylvania",
    95=>"University of Reading",
    96=>"University of Rio de Janeiro",
    97=>"University of Roma Ð La Sapienza",
    98=>"University of Roma-3",
    99=>"University of Rochester",
    100=>"University of Santiago",
    101=>"University of Santiago de Compostella",
    102=>"University of Salzburg",
    103=>"University of Sao Paulo",
    104=>"University of Sheffield",
    105=>"University of St. Andrews",
    106=>"University of Southern California",
    107=>"University of Stockholm",
    108=>"University of Strasbourg",
    109=>"University of Sydney",
    110=>"University of Tel Aviv",
    111=>"University of Texas at Austin",
    112=>"University of Tokyo",
    113=>"University of Torino",
    114=>"University of Toronto",
    115=>"University of TŸbingen",
    116=>"University of Utrecht",
    117=>"University of Valencia",
    118=>"University of Vienna",
    119=>"University of  Warsaw",
    120=>"University of Washington",
    121=>"University of Wisconsin - Madison",
    122=>"University of Zurich",
    123=>"Uppsala University",
    124=>"Vanderbilt University",
    125=>"Washington University in St. Louis",
    126=>"Yale University"
];

$speakers_list = $authors_list;

$campiSoggettivi = [
    "Deepening" => "How in depth was the explanation?",
    "Disclosure" => "Do you think the video is informative?",
    "Summary" => "Do you think the video is synthetic?",
    "Consistency" => "Do you think the video is appropriate to your level of knowledge?",
    "Entertainment" => "Has the explanation bored you?",
    "Difficulty" => "Did it seem like a difficult explanation?",
    "Quality" => "Do you think the video is of good quality?"
];

$campiGrafici = array("G_qualità", "G_semplicità", "G_supporto", "G_coerenza");

$opzioni_campiSoggettivi = [
    1=>"Not at all",
    2=>"A little",
    3=>"Quite",
    4=>"Very much",

];

$opzioni_consistency = [
    1=>"No, I didn't understand anything or the explanation was much too simple.",
    2=>"Not much, I didn\'t understand most of the concepts or there was nothing new for me.",
    3=>"Sufficient, sometimes the new concepts were too easy or incomprehensible.",
    4=>"Yes, I learn new concepts and I connected them easily with what I already knew.",

];

$opzioni_Difficulty = [
    1=>"For experts",
    2=>"Difficult but understandable",
    3=>"Not difficult",
    4=>"Elementary",

];

$opzioni_Quality = [
    1=>"Dreadful",
    2=>"Decent",
    3=>"Good",
    4=>"Great",

];

$tabelle_in_db = array("argomento","arg_stogeo", "autori", "campi_grafici", "campi_soggettivi", "speaker", "tags", "tipologia_video", "universita", "unlisted");


$help_text = [
    "Deepening" => "How much is deep an explanation is not necessary related to the quality of the content. There could be great introductory content not deep, or deep but terrible technical explanation.",
    "Disclosure" => "You have to mainly consider the quality of the speech and of the explanatory  structure. A very informative/didactic content means a clear and precise explanation for a large crowd. A content can be judged informative/didactic independently of the quality",
    "Summary" => "Give your judgment concerning how much concise is the video, independently of the quality of the content ",
    "Consistency" => "Consistency is very different from Quality. You can find low quality content but appropriate for your level of education, with the right balance between new concepts and what you already knew.",
    "Entertainment" => "Was the speaker captivating?? Was the rhythm of the explanation pressing? Was the visual content catchy?",
    "Difficulty" => addslashes("Did it seem like a difficult explanation? It's a general question that concern the difficulty of all the content and all the explanation. Answer generally, don't focus only on part of the content, like the visual part (sometimes, there is great explanation with terrible visual part, and a correct judgement could be in the middle)."),
    "Quality" => addslashes("Do you think the video is of good quality? It's a general question that concern the quality of all the content and all the explanation. Answer generally, don't focus only on part of the content, like the visual part (sometimes, there is great explanation with terrible visual part, and a correct judgement could be in the middle).")
];

$ed_lvl_help_text = addslashes("Elementary School -> Scuola Elementare<br>High School -> Liceo<br>Bachelor's Degree -> Studente Universitario/Laureato triennale<br>Master's Degree -> Studente Universitario/Laureato Magistrale<br>Doctoral Student -> Studente di Dottorato<br>PhD/Researcher/Professor -> PhD/Ricercatore/Professore Universitario ");
$survey_help_text = addslashes("Your answer have to be relativized to your level of education. For example,  if you're a Bachelor's student you can say you know a topic in depth if it is concerning the thesis in your plan, even if obviously it is not 'in depth' like a Teacher.");
$uni_help_text = addslashes("Insert all the universities inherent to the video, for example the location where the conference/lesson is held or the universities where the speaker comes from.");
$thematic_help_text = addslashes("If you have problems finding the correct topic, get help at this <a href='https://philpapers.org/categories.pl' target='_blank'>link</a>. You could also use its search engine to find suggestions about the keyword you're searching.");
$tags_help_text = addslashes("Write at least 5 tags separate with a comma, writing something not already selected in “name of author”or “category”. Start from titles of books, and names of theories related to the topic/author or mentioned in the speech. Next think about other authors related, names of specific problems under discussion, names of schools of thought, etc.. <br>Ex: 'Philosophical investigations', 'Metaphysics', 'Discourse on the method', etc. or 'Family resemblance', 'Context principle', 'Vienna Circle', etc");
$visual_quality_help_text = addslashes("For content like cartoons or slide presentations, consider the quality of the drawing/graphic and the quantity of information carried by the visual part.");
$visual_simplicity_help_text = addslashes("Are the images smooth? Are they in a correct and linear sequence? Or is the visual part chaotic and hectic? Consider the rhythm and the density of information.");