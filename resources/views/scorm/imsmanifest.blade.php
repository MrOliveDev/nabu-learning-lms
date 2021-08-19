<?xml version="1.0" encoding="utf-8" standalone="no"?>
<manifest
    identifier="scorm.k2s"
    version="1"
    xmlns="http://www.imsglobal.org/xsd/imscp_v1p1"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_v1p3"
    xmlns:adlseq="http://www.adlnet.org/xsd/adlseq_v1p3"
    xmlns:adlnav="http://www.adlnet.org/xsd/adlnav_v1p3"
    xmlns:imsss="http://www.imsglobal.org/xsd/imsss"
    xsi:schemaLocation="http://www.imsglobal.org/xsd/imscp_v1p1
                        imscp_v1p1.xsd
                        http://www.adlnet.org/xsd/adlcp_v1p3
                        adlcp_v1p3.xsd
                        http://www.adlnet.org/xsd/adlseq_v1p3
                        adlseq_v1p3.xsd
                        http://www.adlnet.org/xsd/adlnav_v1p3
                        adlnav_v1p3.xsd
                        http://www.imsglobal.org/xsd/imsss
                        imsss_v1p0.xsd">
    <metadata>
        <schema>ADL SCORM</schema>
        <schemaversion>2004 3rd Edition</schemaversion>
    </metadata>
    <organizations default="K2s2">
        <organization identifier="K2s2" adlseq:objectivesGlobalToSystem="false">
            <title>{{ $training->name }}</title>
            @foreach($builtLessons as $lesson)
            <item identifier="item_{{ $lesson['id'] }}" identifierref="resource_{{ $lesson['idFabrica'] }}">
                <title>{{ $lesson['name'] }}</title>
                <imsss:sequencing>
                    <imsss:deliveryControls completionSetByContent="true" objectiveSetByContent="true" />
                </imsss:sequencing>
            </item>
            @endforeach
            <imsss:sequencing>
                <imsss:controlMode choice="true" flow="true" />
            </imsss:sequencing>
        </organization>
    </organizations>
    <resources>
        @foreach($builtLessons as $lesson)
        <resource identifier="resource_{{ $lesson['idFabrica'] }}" type="webcontent" adlcp:scormType="sco" href="{{ $lesson['indexfile'] }}">
            <file href="{{ $lesson['indexfile'] }}" />
        </resource>
        {/foreach}
    </resources>
</manifest>
