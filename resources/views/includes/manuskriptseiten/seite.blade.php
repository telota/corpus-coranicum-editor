@include("includes.forms.select", array(
            "options" => array(
            "r" => "r",
            "v" => "v",
            "bis" => "bis",
            "bis r" => "bis r",
            "bis v" => "bis v",
            "ter" => "ter",
            "ter r" => "ter v",
            "ter v" => "ter v",
            ""=> "keine Angabe"),
            "default" => $manuskriptseite->Seite
            ))