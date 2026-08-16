# Knucklebones CLI Game

A PHP command-line implementation of the **Knucklebones** dice game.

---

## Rules of the Game

Knucklebones is played on two **3×3 grids** (one for each player). 

1. **Take Turns:** On your turn, roll a 6-sided die and place it into one of your 3 columns.
2. **Multiply Score:** If you place multiple dice with the same value in the *same column*, their values are multiplied:
   * **1 Die:** Face value (e.g., $5 = 5$)
   * **2 Matching Dice:** $(5 + 5) \times 2 = 20$
   * **3 Matching Dice:** $(5 + 5 + 5) \times 3 = 45$
3. **Destroy Opponent's Dice:** Placing a die in a column **destroys all dice** of the same value in the opponent's corresponding column!
4. **Game End:** The game ends immediately when either player's 3×3 grid is completely filled. The player with the highest total score wins.

---

## How to Run

1. Clone the repository and install dependencies:
   ```bash
   composer install
