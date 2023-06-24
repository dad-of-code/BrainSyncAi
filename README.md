# BrainSyncAi
 A simple php website that generates binaural beats for any purpose using insights from ChatGPT.


## How to use

### Requirements 

- PHP 8.1+
- Curl
- ChatGPT API Key
- Database

### Setup

1. Upload to environment
2. Run `composer install`
3. Create a database and add the brainsyncai.sql to the database
5. Add database details to the env
6. Add a chatGPT api into the env
7. Rename the env to .env
8. Launch the website

### Note

This uses PHP to create the WAV files and is not efficient. So it does require quite a bit of RAM. I have it overidding the php.ini with 1G of ram. (We can probably come up with a better way to do this.)

### Disclaimer

This was just a quick project I came up with and results could differ. I used chatGPT to help write the code as well, this project was a test of chat's capabilities. If you find interest in this project, feel free to join me in improving and expanding it! 

