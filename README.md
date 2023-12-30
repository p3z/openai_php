# openai_php
Connect a PHP project to the OpenAI API without any extra packages.

I wanted to use OpenAI's API in a lightweight project using as few packages as possible and couldnt find any existing examples that do it.
Therefore I built this. It's just 2 files and no dependencies. Simple ^_^

### Setup
- Set up a simple (and i mean very simple) config file with your API key
- Adapt index.php as needed

### What's the point in the config.php file? Couldn't its $env array just be directly inside index.php?
Technically, yes. Yet it could and that'll work. Not a good idea though. It's bad practice to commit your API keys to any projects' version control system, lest they become public knowledge. So I'm using the config.php file as the equivalent of a .env file to keep our API keys safe from version control (note the reference the config.php inside the gitignore file). I'm not using .env because I didn't want to use any other packages at all.
