@props(['internship', 'searchedTag' => null])

<x-wide-internship-card-main 
    :internship="$internship" 
    :searchedTag="$searchedTag" 
    showTransition="true" 
    containerClasses="h-32" 
    tagsClasses="z-10"
/>