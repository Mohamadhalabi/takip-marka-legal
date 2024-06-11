<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Klassen Sprachzeilen
    |--------------------------------------------------------------------------
    */

    'title' => 'ERWEITERTE SUCHE',
    'subtitle-1' => 'EXAKTE ÜBEREINSTIMMUNG',
    'subtitle-1-description' => '<p>Die Markenrechtsverfolgung liefert ähnliche Keywords in den Suchergebnissen. Das Erfassen ähnlicher Marken ist in den meisten Fällen erwünscht, aber manchmal möchten Sie, dass das System nur exakte Übereinstimmungen liefert und keine Ähnlichkeiten für diese Marke berücksichtigt. In diesem Fall können Sie die Option der exakten Übereinstimmung verwenden.<br><br>Das System erkennt die Option der exakten Übereinstimmung durch Anführungszeichen (" "). Wenn ein Ausdruck zwischen zwei Anführungszeichen platziert wird, wird dies als gewünschte exakte Übereinstimmung interpretiert und nur Marken, die genau zu diesem Ausdruck passen, werden in den Ergebnissen angezeigt. Um die Option der exakten Übereinstimmung zu verwenden, können Sie in Ihrer Marke zwei doppelte Anführungszeichen verwenden oder im Markeneintrag auf das Kästchen "exakte Übereinstimmung" klicken.</p>',
    'subtitle-2' => 'Exakte Übereinstimmung für eine exakte Suche',
    'subtitle-2-description' => '<p>Einige Markeninhaber sind nicht daran interessiert, sich gegen ähnliche Marken zu wehren, sondern möchten nur sehen, ob eine exakte Übereinstimmung mit ihrer Marke besteht. In diesem Fall ist es angemessen, die Option der exakten Übereinstimmung für die gesamte Marke zu verwenden.</p>',
    'subtitle-2-description-2' => '<p>Wenn wir unsere Marke eingeben und das Kästchen für die exakte Übereinstimmung aktivieren, können wir diese Einstellung vornehmen.</p>',
    'subtitle-3' => 'Exakte Übereinstimmung zur Erzwingung von Schlüsselwörtern',
    'subtitle-3-description' => '<p>Einige Marken bestehen aus mehreren Wörtern. Das System erzwingt nicht immer, dass alle Wörter in Marken mit drei oder mehr Wörtern enthalten sind. In einigen Fällen können jedoch bestimmte Wörter erwünscht sein, die in der Übereinstimmung vorhanden sein sollen. Angenommen, wir haben eine dreiwörtige Marke namens <strong>elektrik ticaret sanayi</strong>. Wenn wir uns nur für Ergebnisse interessieren, die nur <strong>ticaret sanayi</strong> enthalten, können wir verlangen, dass das Wort <strong>elektrik</strong> in den Ergebnissen enthalten sein muss.</p>',
    'subtitle-3-description-2' => '<p>Lassen Sie uns die Suche als <strong>"elektrik" ticaret sanayi</strong> festlegen.</p>',
    'subtitle-4' => 'Exakte Übereinstimmung zur Filterung von Wortübereinstimmungen',
    'subtitle-4-description' => '<p>Einige Wörter, insbesondere kurze Wörter, können vielen anderen Wörtern ähnlich sein. Nehmen wir zum Beispiel das Wort "marka". Wenn es häufig mit ähnlichen Wörtern wie "market" übereinstimmt, aber wir uns nicht für diese interessieren, können wir das Wort "marka" durch exakte Übereinstimmung filtern und alle anderen irrelevanten Übereinstimmungen ausschließen.</p>',
    'subtitle-4-description-2' => '<p>Lassen Sie uns jetzt die Suche erneut mit dem Ausdruck <strong>marka</strong> als exakte Übereinstimmung durchführen.</p>',
    'subtitle-5' => 'Exakte Übereinstimmung, um bestimmte Ähnlichkeiten auszuschließen',
    'subtitle-5-description' => '<p>Die Option der exakten Übereinstimmung kann auch nur auf bestimmte Zeichen in einem Wort angewendet werden. In diesem Fall werden Ergebnisse, bei denen das angegebene Wort nicht genau mit dem gewünschten Ausdruck übereinstimmt, aus den Ergebnissen herausgefiltert.</p>',
    'subtitle-5-description-2' => '<p>Je nachdem, nach welchem Schlüsselwort Sie suchen, kann das Hinzufügen eines Zeichens zur exakten Übereinstimmung die Ergebnisse entsprechend anpassen.</p>',
    'subtitle-5-description-3' => '<p>Lassen Sie uns jetzt das Schlüsselwort <strong>okulları</strong> suchen und die Ergebnisse sehen.</p>',
    'subtitle-5-description-4' => '<p>Wir erhalten unerwünschte Ergebnisse aufgrund der Ähnlichkeit zwischen <strong>okullar-oğullar</strong>. Dies liegt an der Ähnlichkeit zwischen "k" und "ğ".</p>',
    'subtitle-5-description-5' => '<p>Ändern wir das Schlüsselwort in <strong>o"k"ullar</strong> und führen die Suche erneut durch.</p>',
    'subtitle-5-description-6' => '<p>Wie in den Ergebnissen zu sehen ist, wurden die unerwünschten Ergebnisse aufgrund der Ähnlichkeit zwischen "k" und "ğ" gefiltert.</p>',
    'subtitle-6' => 'AUSGESCHLOSSENE WÖRTER',
    'subtitle-6-description' => '<p class="mt-4">Beim Suchen möchten Sie möglicherweise bestimmte Wörter, die in den Ergebnissen angezeigt werden oder wahrscheinlich angezeigt werden, ausschließen. Hierfür können Sie den Filter für ausgeschlossene Wörter verwenden.</p>',
    'subtitle-6-description-2' => '<p>Wenn das von Ihnen hinzugefügte ausgeschlossene Wort genau mit einem Wort übereinstimmt, das mit dem Suchbegriff übereinstimmt, wird es herausgefiltert und Ihnen nicht angezeigt.</p>',
    'subtitle-6-description-3' => '<p>Sie können ausgeschlossene Wörter problemlos verwenden, ohne das Risiko, die verfolgte Marke zu übersehen. Ausgeschlossene Wörter werden nur für das übereinstimmende Wort berücksichtigt und das Ergebnis wird gefiltert, wenn das übereinstimmende Wort genau mit dem ausgeschlossenen Wort übereinstimmt.</p>',
    'subtitle-6-description-4' => '<p>Wenn Sie bei der Filterung die Option der exakten Übereinstimmung verwenden, wird der gesuchte Ausdruck ohne das ausgeschlossene Wort zurückgegeben.</p>',
    'subtitle-6-description-5' => '<p class="mt-4">Die Filterung der ausgeschlossenen Wörter ist einfach. In der Markensuche befindet sich auf der linken Seite der Ergebnisse eine Schaltfläche, auf der "Filter" steht. Wenn Sie darauf klicken, können Sie den Filter für ausgeschlossene Wörter öffnen und dort Wörter hinzufügen oder entfernen.</p>',
    'subtitle-6-description-6' => '<p class="mt-4">Auf diese Weise können Sie die Ergebnisse optimieren und sicherstellen, dass nur relevante Ergebnisse angezeigt werden.</p>',

];