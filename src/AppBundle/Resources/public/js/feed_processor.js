
angular.module('FeedProcessor', [])
    .controller('FeedController', function($scope, $http, $location, $anchorScroll) {
        $scope.url = 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
            + '&additionalType=2&limit=200';
        $scope.offset = 0;
        $scope.limit = 50;
        $scope.totalItemsInFeed = null;
        $scope.products = [];
        $scope.isFormSubmitted = false;

        $scope.submit = function() {
            $scope.offset = 0;
            $scope.getProducts();
        };

        $scope.getProducts = function() {
            $scope.isFormSubmitted = false;
            if ($scope.limit > 100 || $scope.limit <= 0) {
                $scope.limit = 100;
            }
            $http.get(Routing.generate('app_feed_processor_products', {
                xml: $scope.url,
                offset: $scope.offset,
                limit: $scope.limit
            }, true))
            .success(function(response) {
                $scope.totalItemsInFeed = response.totalItemsInFeed;
                $scope.products = response.products;
                $scope.isFormSubmitted = true;
            });
        };

        $scope.isNextPage = function() {
            if ($scope.isFormSubmitted && $scope.offset + $scope.limit < $scope.totalItemsInFeed) {
                return true;
            }

        };
        $scope.nextPage = function() {
            $scope.offset = $scope.offset + $scope.limit;
            $location.hash('feed-form');
            $anchorScroll();
            $scope.getProducts();
        };

        $scope.isPreviousPage = function() {
            if ($scope.isFormSubmitted && $scope.offset > 0) {
                return true;
            }
        };
        $scope.previousPage = function() {
            $scope.offset = $scope.offset - $scope.limit;
            if ($scope.offset < 0 ) {
                $scope.offset = 0;
            }
            $location.hash('feed-form');
            $anchorScroll();
            $scope.getProducts();
        };
    });
