@props(['internship', 'searchedTag' => null])

<x-wide-internship-card-main
    :internship="$internship" 
    :searchedTag="$searchedTag" 
    contentClasses="group-hover:text-blue-800 transition-colors duration-300" 
    linkEmployerName="true"
    containerClasses="h-32" 
    panelClasses='flex gap-x-6  hover:border-blue-800 transition-colors duration-300'


/>