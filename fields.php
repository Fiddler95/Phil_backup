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

$tabelle_in_db = array("argomento","arg_stogeo", "autori", "campi_grafici", "campi_soggettivi", "speaker", "tags", "tipologia_video", "universita", "unlisted");


$help_text = [
    "Tipologia" => "If for example the video is a cartoon on the life of Immanuel Kant, you shall select Cartoon as you Main Typology and Introduction as Secondary ",
    "Autori" => "If in the video Kripke is talking about his theories, but also mentions Russell and Frege, you shall insert the three of them as reference authors",
    "Speaker" => "If in a video Kripke talks about his theory, you will have to insert Kripke both as a Speaker and as a reference Author. Instead, if in a video prof. Penco compares the theories of Wittgenestein and Einstein, Penco will be the speaker, Wittgenestein and Einstein the authors.",
    "Universita" => "There can be more than one result: all the universities involved in the explanation must be taken into account. In the case of ambiguity, opt for the full English name.",
    "Deepening" => "How in depth was the explanation?",
    "Deepening" => "How in depth was the explanation?",
    "Deepening" => "How in depth was the explanation?",
    "Deepening" => "How in depth was the explanation?",
    "Deepening" => "How in depth was the explanation?",
    "Deepening" => "How in depth was the explanation?",
    "Disclosure" => "Do you think the video is informative?",
    "Summary" => "Do you think the video is synthetic?",
    "Consistency" => "Do you think the video is appropriate to your level of knowledge?",
    "Entertainment" => "Has the explanation bored you?",
    "Difficulty" => "Did it seem like a difficult explanation?",
    "Quality" => "Do you think the video is of good quality?"
];
