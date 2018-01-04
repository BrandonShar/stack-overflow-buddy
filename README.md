# Stack Overflow Buddy

Inspired by the revolutionary work done by @drathier and their [stack-overflow-import](https://github.com/drathier/stack-overflow-import), Stack Overflow Buddy is your own personal PHP based Stack Overflow assistant! 

Why spend your valuable time cutting and pasting from StackOverflow when Stack Overflow Buddy can do it for you? Who wouldn't trade all safety checks and only the basest of functionality checks for a bit of convenience?
### Installation 
```
composer require brandonshar/stack-overflow-buddy
```
Because Stack Overflow Buddy uses untagged libraries, you may need to add the following lines to your composer root
```
"minimum-stability": "dev",
"prefer-stable": true
```
```php
# and in your files you use it
use brandonshar\StackOverflowBuddy;
```
---
### What's it do?

Just give it a try!

```php
StackOverflowBuddy::mergeSort([2,3,1,4]);
// [1, 2, 3, 4]
```

*Impressed?* 

How about 

```php
StackOverflowBuddy::substringBetweenTwoStrings('platypus', 'pl', 'us');
// atyp
```
---
### Wow, how's it work?
If you're impressed, you should probably stop reading here. 

1. Split the camelCased function call into words
2. Grab the top scoring PHP tagged questions with those words in the title from StackOverflow's API
3. Grab the top scoring answers for those questions
4. Pull any and all code blocks from those answers
5. Find the first code block that:
   1. Inteprets without error
   2. Contains one or more functions
   3. One of the functions has the same amount of arguments as were passed by the user
6. Then we throw caution to the wind, eval, and call the new method!
---
### Wow, this will change my workflow forever!
It certainly will. But don't forget to use some of that time you're saving to thank the original author of the code you've now absorbed.

```php
var_dump(StackOverflowBuddy::giveThanksFor('substringBetweenTwoStrings'));
/*
["author"]=>
  string(18) "Alejandro Iglesias"
  ["authorLink"]=>
  string(57) "https://stackoverflow.com/users/425741/alejandro-iglesias"
  ["questionLink"]=>
  string(35) "https://stackoverflow.com/a/9826656"
*/
```
---

### What if StackOverflowBuddy can't find any good code for my method?
In the incredibly unlikely (ok... maybe not *incredibly unlikely*) event that StackOverflowBuddy can't find any code that meets your request, it'll throw you a `HaveToWriteYourOwnCodeException` to keep you busy while hopefully someone else gives a better answer on Stack Overflow. 

---

### Testimonials
If you're still on the fence, don't take my word for it; here's what a satisifed reader of the code had to say:
> "I love how this makes on the fly software updates really easy. If I ever need to tweak an algorithm or fix a bug, I just need to submit a really good answer to stack overflow with the updated code. Goodbye source control!"

> \- [Pseudofailure](https://www.reddit.com/r/PHP/comments/6qzuzj/just_released_a_package_to_cut_out_the/dl1ejwg/)
---

### Warning-ware
You're free to use this package, but if it makes it to your production environment you accept the responsibility of personally telling each of your users that they would be better off hiding their data under their mattress.

---

### Notes
Keep in mind that every usage of this makes two requests to the StackOverflow API and they will rate-limit you after a certain number of requests per day. But that shouldn't really be an issue since no one sensible would ever use this for anything.

---

### Contributing
Have a blast. There is currently only one end to end integration test that requires the index.php file to be reachable from a local server. I just used Laravel Valet. This code does not follow PSR-2 and deliberately uses no typehints or visiblity as I decided to do a similar style experiment to the required Zttp library. Even if you're the strictest PHP writer there is, not following a style guide is at best, like the 5th reason you should never use this code. 

---

### License
The Unlicense. If there's a less restrictive license with even less liability, let's go with that. Anyone who thinks that using this license is to the `detriment of my heirs` clearly didn't look at it very carefully.
