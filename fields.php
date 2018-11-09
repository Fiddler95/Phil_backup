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
    4 => "I wrote/am writing a thesis on the subject"];

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

$authors = [
    0=> "Peter Abelard",
    1=>"Alfarabius",
    2=>"Algazel",
    3=>"Alkindus",
    4=>"Albertus de Saxonia",
    5=>"Albertus, Magnus",
    6=>"Jean, d'Alembert",
    7=>"William, Alston",
    8=>"Anaxagoras of Clazomenae",
    9=>"Anaximander of Miletus",
    10=>"Anaximenes of Miletus",
    11=>"Elizabeth, Anscombe",
    12=>"Anselm of Canterbury"
];

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
    "Difficulty" => "Did it seem like a difficult explanation?",
    "Quality" => "Do you think the video is of good quality?"
];

$survey_help_text = addslashes("Your answer have to be relativized to your level of education. For example,  if you're a Bachelor's student you can say you know a topic in depth if it is concerning the thesis in your plan, even if obviously it is not 'in depth' like a Teacher.");
$uni_help_text = addslashes("Insert all the universities inherent to the video, for example the location where the conference/lesson is held or the universities where the speaker comes from.");
$thematic_help_text = addslashes("If you have problems finding the correct topic, get help at this <a href='https://philpapers.org/categories.pl' target='_blank'>link</a>. You could also use its search engine to find suggestions about the keyword you're searching.");
$tags_help_text = addslashes("Write at least 3 tags separate with a comma, writing something not already selected in “name of author”or “category”. For example, insert names of other authors , titles of books, names of theories related to the topic or mentioned in the speech, names of specific problems under discussion, etc..  Ex: 'Philosophical investigations', 'Metaphysics', 'Discourse on the method', etc. or 'Family resemblance', 'Context principle', etc.");
$visual_quality_help_text = addslashes("For content like cartoons or slide presentations, consider the quality of the drawing/graphic and the quantity of information carried by the visual part.");
$visual_simplicity_help_text = addslashes("Are the images smooth? Are they in a correct and linear sequence? Or is the visual part chaotic and hectic? Consider the rhythm and the density of information.");