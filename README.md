## Table of contents
* [My thoughts about the code](#my-thoughts-about-the-code)
* [Bad things or Need to change structure and logic wise](#bad-things-or-need-to-change-structure-and-logic-wise)



## My thoughts about the code
* Code is neither amazing nor terrible, its OK and needs refactor.
* One good thing is Repository  / service container is used in the code other than this nothing amazing is written to praise.


## Bad things or Need to change structure and logic wise
* $request->all() is used in every method, this can go terrible if data is injected via frontend, API.(injecting huge amount of data came and there you go with gateway error or slowing down app)
* some methods seems to be duplicated and they can be merge into one method to less code in your controller
* too many if else are used, ternary operators and switch cases could be used to minimize code
* there should be error and success method seperatly to quickly identify either we got an error or success, but in code I can see returning same method for error, success message. Its can be so difficult to identify actually.
* Error and Success messages formate is not followed same, it should be generic.
* Error and Success message should not go with direct putting text from controller / repository, messages should come from language (Localization) feature in order to change app language if needed.
* try Exception should be put within every method, transation and thats not followed in the current code.
* for array it is pretented to be a object or null in if condition, it will result unexcepted error
* some variables are used with static values within controller, but if non technical wants to change He/She will always need technical guy
* instead of writting if conditions for alot of queries there should be function queries in order to write less queries in controller


