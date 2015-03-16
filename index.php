<?php

	// complete all "todo"s to build a blackjack game
	// create an array for suits
	$suits = ['C', 'H', 'S', 'D'];
	// create an array for cards
	$cards = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
	// build a deck (array) of cards
	// card values should be "VALUE SUIT". ex: "7 H"
	// make sure to shuffle the deck before returning it: shuffle()
	function buildDeck($suits, $cards) {
		$newDeck = array();
	  	foreach($suits as $suit){
	  		foreach($cards as $card){
	  			$newDeck[] = "$card $suit";
	  		}
	  		shuffle($newDeck);
	  		shuffle($newDeck);
	  		shuffle($newDeck);
	  	}
	  	return $newDeck;
	}
	// Remove the suit from the card so that it may be evaluated
	function removeSuit($card) {
	  	$card = explode(' ', $card);
	  	array_pop($card);
	  	$card = implode(' ', $card);
		return $card;
	}
	//Test function:
		// echo removeSuit('A H').PHP_EOL;
	
	// determine the value of an individual card (string)
	// aces are worth 11
	// face cards are worth 10
	// numeric cards are worth their value
	function getCardValue($card) {
	  	$card = removeSuit($card);
	  	if ($card == 'A'){
	  		$value = 11;
	  	} elseif ($card == 'J' || $card == 'Q' || $card == 'K') {
	  		$value = 10;
	  	} else {
	  		$value = $card;
	  	}
	  	return $value;
	}
	// Test function:
		// echo getCardValue('4 H').PHP_EOL;

	// get total value for a hand of cards
	// don't forget to factor in aces
	// aces can be 1 or 11 (make them 1 if total value is over 21)
	function getHandTotal($hand) {
	  	foreach($hand as $eachCard){
	  		if(getCardValue($eachCard) == 11 && $handTotal >= 11){
	  			$handTotal += 1;
	  		} else {
	  			$handTotal += getCardValue($eachCard);
	  		}
	  	}
		return $handTotal;
	}
	// Test function:
		// $hand = ['3 H', 'Q C', 'A S'];
		// echo getHandTotal($hand).PHP_EOL;

	// draw a card from the deck into a hand
	// pass by reference (both hand and deck passed in are modified)
	function drawCard(&$hand, &$deck) {
		$hand[] = $deck[0];
		array_shift($deck);
	}

	// print out a hand of cards
	// name is the name of the player
	// hidden is to initially show only first card of hand (for dealer)
	// output should look like this:
	// Dealer: [4 C] [???] Total: ???
	// or:
	// Player: [J D] [2 D] Total: 12
	function echoHand($hand, $name, $hidden = false) {
	  	if($hidden){
	  		echo "$name: [$hand[0]] [???] Total: ???".PHP_EOL;
	  	} else {
	  		$cardsInHand = '';
		  	foreach($hand as $eachCard){
		  		$cardsInHand .= " [$eachCard]"; 
		  	}
			echo "$name:".$cardsInHand." Total: ".getHandTotal($hand).PHP_EOL;
		}
	}
	// build the deck of cards
	$deck = buildDeck($suits, $cards);
	// Test function:
		// print_r($deck);

	// initialize a dealer and player hand
	$dealer = [];
	$player = [];
	// $testPlayer = ['K S', 'A C', 'A D'];
	
	// Test:
		// print_r($player);
		// print_r($dealer);
		// echoHand($testPlayer, "Test");

	// dealer and player each draw two cards
	drawCard($player, $deck);
	drawCard($player, $deck);
	// print_r($deck);
	drawCard($dealer, $deck);
	drawCard($dealer, $deck);
	// print_r($deck);

	// echo the dealer hand, only showing the first card
	echoHand($dealer, 'Dealer', true);
	// echo the player hand
	echoHand($player, 'Player');

	// allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
	while (getHandTotal($player) < 21) {
		  echo "(H)it or (S)tay?\n";
		  $choice = strtoupper(trim(fgets(STDIN)));
		  if ($choice == 'H'){
		  	drawCard($player, $deck);
		  	echoHand($player, 'Player');
		  } elseif ($choice == 'S'){
		  		break;	
		  }
	}
	// show the dealer's hand (all cards)
	echoHand($dealer, 'Dealer'); 

	// at this point, if the player has more than 21, tell them they busted
	if(getHandTotal($player) > 21){
		echo "You Busted *_*\n";
		exit(0);
	// otherwise, if they have 21, tell them they won (regardless of dealer hand)
	} else if(getHandTotal($player) == 21){
		echo "BlackJack!!! You Won! ^_^\n";
		exit(0);
	// if neither of the above are true, then the dealer needs to draw more cards
	// dealer draws until their hand has a value of at least 17
	// show the dealer hand each time they draw a card
	} else {
		while(getHandTotal($dealer) < 17){
			drawCard($dealer, $deck);
			echoHand($dealer, 'Dealer');
		}
	}
	
	// finally, we can check and see who won
	// by this point, if dealer has busted, then player automatically wins
	if(getHandTotal($dealer) > 21){
		echo "Dealer busts, you win! ^_^\n";
	// if player and dealer tie, it is a "push"
	} elseif (getHandTotal($dealer) == getHandTotal($player)){
		echo "You and the Dealer tied, it's a PUSH! -_-\n";
	// if dealer has more than player, dealer wins, otherwise, player wins
 	} elseif (getHandTotal($dealer) > getHandTotal($player)){
 		echo "Dealer Won! -_-\n";
 	} else {
 		echo "You Won! ^_^\n";
 	}




?>