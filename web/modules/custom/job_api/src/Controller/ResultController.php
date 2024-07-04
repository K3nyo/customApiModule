<?php
namespace Drupal\job_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\job_api\Form\testForm;
use Jobles\Careerjet\Api;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides route responses for the Job Api module.
 */
class ResultController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  // public function myPage(Request $request) {

  //   // if ( $result->type == 'JOBS' ){
  //   //   echo "Found ".$result->hits." jobs" ;
  //   //   echo " on ".$result->pages." pages\n" ;
  //   //   $jobs = $result->jobs ;
      
  //   //   foreach( $jobs as $job ){
  //   //     echo " URL:     ".$job->url."\n" ;
  //   //     echo " TITLE:   ".$job->title."\n" ;
  //   //     echo " LOC:     ".$job->locations."\n";
  //   //     echo " COMPANY: ".$job->company."\n" ;
  //   //     echo " SALARY:  ".$job->salary."\n" ;
  //   //     echo " DATE:    ".$job->date."\n" ;
  //   //     echo " DESC:    ".$job->description."\n" ;
  //   //     echo "\n" ;
  //   //   }
  //   //   # Basic paging code
  //   //   if( $page > 1 ){
  //   //     echo "Use \$page - 1 to link to previous page\n";
  //   //   }
  //   //   echo "You are on page $page\n" ;
  //   //   if ( $page < $result->pages ){
  //   //     echo "Use \$page + 1 to link to next page\n" ;
  //   //   }
  //   // }
  //   // dump($result);

  //   $test_keyword = $request->query->get('test_keyword');
  //   $test_country = $request->query->get('test_country');
  //   $test_city = $request->query->get('test_city');
    
  //   // $build = [
  //   //   // '#theme' => 'job_api',
  //   //   '#markup' => $this->t('Hello World!'),
  //   //   // '#test_keyword' => $keyword,
  //   //   // '#test_country' => $country,
  //   //   // '#test_city' => $country,
  //   // ];
  //   // return $build;
  //   $output = [
  //     '#theme' => 'job_api', // The name of your Twig template file without the .html.twig extension.
  //     '#test_keyword' => $test_keyword,
  //     '#test_country' => $test_country,
  //     '#test_city' => $test_city,
  //   ];

  //   return $output;
  // }
  public function myPage(Request $request) {


    $test_keyword = $request->query->get('test_keyword');
    $test_country = $request->query->get('test_country');
    $test_city = $request->query->get('test_city');

    $cjapi = new Api('678bdee048', $test_country, 'English');
    // $result = $cjapi->search(['keywords' => 'Nurse', 'limit' => 3]);
    $result = $cjapi->search([
      'keywords' => $test_keyword,
      'location' => $test_city,
      'affid' => '678bdee048',
    ]);
  
    // dump($result->getIterator()->data);
    $jobs = [];
    // while($result->getIterator()->next()) {
    //   $loop[] = $result->getIterator()->current();
    // }
    if ($result->getIterator()->count() > 0){
      foreach(range(0,$result->getIterator()->count()) as $key) {
        $result->getIterator()->next();
        // $jobs[] = $result->getIterator()->current();
        $jobs[] = [ 
          'title' => $result->getIterator()->current()->getTitle(),
          'description' => $result->getIterator()->current()->getSnippet(),
          'salarymax' => $result->getIterator()->current()->getSalaryMax(),
          'salarymin' => $result->getIterator()->current()->getSalaryMin(),
        ];
      }
    }


    // dump($jobs);

    $build = [
      '#theme' => 'job_api',
      '#test_keyword' => $test_keyword,
      '#test_country' => $test_country,
      '#test_city' => $test_city,
      '#jobs' => $jobs,
    ];
    
    return $build;
  }

}
