<!DOCTYPE html>
<html lang="en">
<x-head :title="'QuizTech | Home'" />

<body>
    <x-nav-bar-main :user="$user" />

    <div class="login-box">
        <x-button-main :title="'All Quizzes'" :adress="'/allquizzes'" />
        <x-button-main :title="'Create Quiz'" :adress="'/quizform'" />
           </div>
</body>

</html>
