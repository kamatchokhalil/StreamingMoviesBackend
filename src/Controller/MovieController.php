<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Reviews;
use App\Entity\User;
use App\Repository\FavorisRepository;
use App\Repository\MovieCategoriesRepository;
use App\Repository\MovieRepository;
use App\Repository\ReviewsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MovieController extends AbstractController
{
    /**
     * @Route("/AllMovie", name="AllMovie")
     */
    public function index(NormalizerInterface $normalizer, MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        try {
            $jsonContent = $normalizer->normalize($movies, 'json', ['groups' => "movie:read", "movieCategories:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/movie/add", name="addMovie")
     */
    public function addMovie(Request $request, NormalizerInterface $normalizer, MovieCategoriesRepository $movieCategoriesRepository, EntityManagerInterface $em): Response
    {
        $movies = new Movie();
        $uploadVideo = $request->get('video');
        $uploadFile = $request->get('image');

        $data = $_FILES['image']['tmp_name'] = 'kamatcho';
        $data2 = $_FILES['video']['tmp_name'] = 'kamatcho';

        $moviecategories = $movieCategoriesRepository->findBy(['id' => $request->get('MovieCategories')]);
        $movies->setMovieCategories($moviecategories[0]);
        $movies->setTitle($request->get('title'));
        $movies->setSummary($request->get('summary'));
        $movies->setUrl($request->get('url'));
        $movies->setDuration($request->get('duration'));
        $movies->setQuality($request->get('quality'));
        $movies->setTrans($request->get('trans'));
        $movies->setDateSortie(\DateTime::createFromFormat('Y-m-d', $request->get('dateSortie')));
        $movies->setNumVisits(0);
        $movies->setOverallRate(0);
        $movies->setImg('url');
        $movies->setFree('free');
        $em->persist($movies);
        $em->flush();
        try {
            $jsonContent = $normalizer->normalize($data, 'json', ['groups' => "movie:read", "movieCategories:read"]);
            /*            return $this->json([
                            'message' => 'OK',
                            'path' => 'src/Controller/ArticleController.php',
                        ]);*/

            /*           return new JsonResponse($data, 200, array('Access-Control-Allow-Origin'=> '*'));*/

        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/movie/upload", name="upload")
     */
    public function upload(Request $request, NormalizerInterface $normalizer, MovieCategoriesRepository $movieCategoriesRepository, EntityManagerInterface $em): Response
    {
        //$file = $request->files->get('filmUpload');
        //$file = $request->get('filmUpload');
        $file = file_get_contents($request->files->get('filmUpload'));
        //$file = file_get_contents($_FILES['filmUpload']['tmp_name']);
        return new Response(json_encode($file));

    }

    /**
     * @Route("/movie/increment", name="increment")
     */
    public function incrementVues(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $movie = $movieRepository->findBy(['id' => $request->get('movieID')]);
        $movie[0]->setNumVisits($movie[0]->getNumVisits() + 1);
        $em->flush();

        try {
            $jsonContent = $normalizer->normalize($movie, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/topMovies", name="topMovies")
     */
    public function topMovies(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {

        /*              $res = $movieRepository->createQueryBuilder('movies')
                           ->where('skills.users.id = :users_id')
                           ->setParameter('users_id',3)
                           ->getQuery()->getScalarResult();  */

        $result = $movieRepository->createQueryBuilder('movies')
            ->orderBy('movies.numVisits', 'DESC')
            ->setMaxResults(5)
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/lastMovies", name="lastMovies")
     */
    public function lastMovies(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $result = $movieRepository->createQueryBuilder('movies')
            ->orderBy('movies.dateSortie', 'DESC')
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }


    /**
     * @Route("/movie/lastweekMovies", name="lastweekMovies")
     */
    public function lastweekMovies(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $lastWeek = date("Y-m-d", strtotime("-7 days"));
        $result = $movieRepository->createQueryBuilder('movies')
            ->where('movies.dateSortie >= :lastweek')
            ->setParameter('lastweek', $lastWeek)
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/mostVisitedMovie", name="mostVisitedMovie")
     */
    public function mostVisitedMovie(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $result = $movieRepository->createQueryBuilder('movies')
            ->orderBy('movies.numVisits', 'DESC')
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/NumMoviesCatid", name="NumMoviesCatid")
     */
    public function numberOfMoviesCatID(Request $request, NormalizerInterface $normalizer, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {

        /*              $res = $movieRepository->createQueryBuilder('movies')
                           ->where('skills.users.id = :users_id')
                           ->setParameter('users_id',3)
                           ->getQuery()->getScalarResult();  */

        /* SELECT COUNT(`movie_categories_id`)FROM `movie`*/
        $catId = $request->get('catid');
        $result = $movieRepository->createQueryBuilder('movies')
            ->select('count(movies.MovieCategories)')
            ->where('movies.MovieCategories = :catid')
            ->setParameter('catid', $catId)
            ->getQuery()->getScalarResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "movie:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/getMovieFavExist", name="getMovieFavExist")
     */
    public function getFavByMovieID(Request $request, NormalizerInterface $normalizer, FavorisRepository $favorisRepository, EntityManagerInterface $em): Response
    {
        $movie_id = $request->get('movie');
        $user_id = $request->get('user');
        $result = $favorisRepository->createQueryBuilder('favoris')
            ->where('favoris.FilmID = :movie_id')
            ->andWhere('favoris.UserID = :user_id')
            ->setParameters(['user_id' => $user_id, 'movie_id' => $movie_id])
            ->getQuery()->getResult();
        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "favoris:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/getFav", name="getFav")
     */
    public function getFavByUserID(Request $request, NormalizerInterface $normalizer, FavorisRepository $favorisRepository, EntityManagerInterface $em): Response
    {
        $user_id = $request->get('user');
        $result = $favorisRepository->createQueryBuilder('favoris')
            ->where('favoris.UserID = :user_id')
            ->setParameter('user_id', $user_id)
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "favoris:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/deleteFav", name="deleteFav")
     */
    public function deleteFavByUserID(Request $request, NormalizerInterface $normalizer, FavorisRepository $favorisRepository, EntityManagerInterface $em): Response
    {
        $user_id = $request->get('user');
        $movie_id = $request->get('movie');
        $result = $favorisRepository->createQueryBuilder('favoris')
            ->delete()
            ->where('favoris.FilmID = :movie_id')
            ->andWhere('favoris.UserID = :user_id')
            ->setParameters(['user_id' => $user_id, 'movie_id' => $movie_id])
            ->getQuery()->getResult();

        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "favoris:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/addReview", name="addReview")
     */
    public function addReview(Request $request, NormalizerInterface $normalizer, ReviewsRepository $reviewsRepository,
                              UserRepository $userRepository, MovieRepository $movieRepository, EntityManagerInterface $em): Response
    {
        $user = $userRepository->findBy(['id' => $request->get('user')]);
        $movie = $movieRepository->findBy(['id' => $request->get('movie')]);
        $review = new Reviews();
        $review->setMovieID($movie[0]);
        $review->setUserID($user[0]);


        $review->setDatecomment(date("d-m-Y"));
        $review->setComment($request->get('comment'));
        $review->setRate($request->get('rate'));

        $em->persist($review);
        $em->flush();
        try {
            $jsonContent = $normalizer->normalize($review, 'json', ['groups' => "reviews:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/movie/getReviewByUserID", name="getReviewByUserID")
     */
    public function getReviewByUserID(Request $request, NormalizerInterface $normalizer, ReviewsRepository $reviewsRepository, EntityManagerInterface $em): Response
    {
        $user_id = $request->get('user');
        $movie_id = $request->get('movie');
        $result = $reviewsRepository->createQueryBuilder('reviews')
            ->where('reviews.userID = :user_id')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameters(['user_id' => $user_id, 'movie_id' => $movie_id])
            ->getQuery()->getResult();



        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "reviews:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }

        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/updateReview", name="updateReview")
     */
    public function updateReview(Request $request, NormalizerInterface $normalizer, ReviewsRepository $reviewsRepository, EntityManagerInterface $em): Response
    {

        $user_id = $request->get('user');
        $movie_id = $request->get('movie');

        $review = new Reviews();
        $review = $reviewsRepository->findBy(['userID' => $user_id, 'movieID' => $movie_id]);
        $review[0]->setDatecomment(date("d-m-Y"));
        $review[0]->setComment($request->get('comment'));
        $review[0]->setRate($request->get('rate'));

        $em->flush();
        try {
            $jsonContent = $normalizer->normalize($review, 'json', ['groups' => "reviews:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/movie/getSumRate", name="getSumRate")
     */
    public function getSumRate(Request $request, NormalizerInterface $normalizer, ReviewsRepository $reviewsRepository, EntityManagerInterface $em): Response
    {

        $movie = $request->get('movie');
        $result = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS nbrAllReviews')
            ->where('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $resultStars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS allStars')
            ->where('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $result5stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS five')
            ->where('reviews.rate = 5')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $result4stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS four')
            ->where('reviews.rate = 4')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $result3stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS three')
            ->where('reviews.rate = 3')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $result2stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS two')
            ->where('reviews.rate = 2')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();


        $result1stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('SUM(reviews.rate) AS one')
            ->where('reviews.rate = 1')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();


        $nbr = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS total')
            ->where('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $nbrUsers5Stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS fiveUsers')
            ->where('reviews.rate = 5')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $nbrUsers4Stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS fourUsers')
            ->where('reviews.rate = 4')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $nbrUsers3Stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS threeUsers')
            ->where('reviews.rate = 3')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $nbrUsers2Stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS twoUsers')
            ->where('reviews.rate = 2')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();

        $nbrUsers1Stars = $reviewsRepository->createQueryBuilder('reviews')
            ->select('COUNT (DISTINCT reviews.userID) AS oneUsers')
            ->where('reviews.rate = 1')
            ->andWhere('reviews.movieID = :movie_id')
            ->setParameter(':movie_id', $movie)
            ->getQuery()->getResult();


        if ($nbr[0]['total'] == null){
            $result[0]['movieReviews'] = "0";
        }else{
            $result[0]['movieReviews'] = $nbr[0]['total'];
        }



        if ($result5stars[0]['five'] == null){
            $result[0]['five'] = "0";
        }else{
            $result[0]['five'] = $result5stars[0]['five'];
        }

        if ($result4stars[0]['four'] == null){
            $result[0]['four'] = "0";
        }else{
            $result[0]['four'] = $result4stars[0]['four'];
        }

        if ($result3stars[0]['three'] == null){
            $result[0]['three'] = "0";
        }else{
            $result[0]['three'] = $result3stars[0]['three'];
        }

        if ($result2stars[0]['two'] == null){
            $result[0]['two'] = "0";
        }else{
            $result[0]['two'] = $result2stars[0]['two'];
        }

        if ($result1stars[0]['one'] == null){
            $result[0]['one'] = "0";
        }else{
            $result[0]['one'] = $result1stars[0]['one'];
        }





        $result[0]['users5Stars'] = $nbrUsers5Stars[0]['fiveUsers'];
        $result[0]['Users4Stars'] = $nbrUsers4Stars[0]['fourUsers'];
        $result[0]['users3Stars'] = $nbrUsers3Stars[0]['threeUsers'];
        $result[0]['users2Stars'] = $nbrUsers2Stars[0]['twoUsers'];
        $result[0]['users1Stars'] = $nbrUsers1Stars[0]['oneUsers'];






        if ($nbrUsers5Stars[0]['fiveUsers']>0){
            $result[0]['mo5'] = $result5stars[0]['five']/$nbrUsers5Stars[0]['fiveUsers'];
        }else{
            $result[0]['mo5'] = "0";
        }

        if ($nbrUsers4Stars[0]['fourUsers']>0){
            $result[0]['mo4'] = $result4stars[0]['four']/$nbrUsers4Stars[0]['fourUsers'];
        }else{
            $result[0]['mo4'] = "0";
        }

        if ($nbrUsers3Stars[0]['threeUsers']>0){
            $result[0]['mo3'] = $result3stars[0]['three']/$nbrUsers3Stars[0]['threeUsers'];
        }else{
            $result[0]['mo3'] = "0";
        }

        if ($nbrUsers2Stars[0]['twoUsers']>0){
            $result[0]['mo2'] = $result2stars[0]['two']/$nbrUsers2Stars[0]['twoUsers'];
        }else{
            $result[0]['mo2'] = "0";
        }

        if ($nbrUsers1Stars[0]['oneUsers']>0){
            $result[0]['mo1'] = $result1stars[0]['one']/$nbrUsers1Stars[0]['oneUsers'];
        }else{
            $result[0]['mo1'] = "0";
        }

        if (($resultStars[0]['allStars']/5)>0){
            $result[0]['mogen'] = $resultStars[0]['allStars']/$nbr[0]['total'];
        }else{
            $result[0]['mogen'] = "0";
        }



        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "reviews:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }
        return new Response(json_encode($jsonContent));

    }

    /**
     * @Route("/movie/getReviewByMovieID", name="getReviewByMovieID")
     */
    public function getReviewByMovieID(Request $request, NormalizerInterface $normalizer, ReviewsRepository $reviewsRepository, EntityManagerInterface $em): Response
    {
        $movie_id = $request->get('movie');
        $result = $reviewsRepository->createQueryBuilder('reviews')
            ->where('reviews.movieID = :movie_id')
            ->setParameter('movie_id' , $movie_id)
            ->orderBy('reviews.id','DESC')
            ->getQuery()->getResult();
        try {
            $jsonContent = $normalizer->normalize($result, 'json', ['groups' => "reviews:read"]);
        } catch (ExceptionInterface $e) {
            echo $e->getMessage();
        }
        return new Response(json_encode($jsonContent));

    }
}
