<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech008 Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        #welcome-section {
            background-color: #0A3D62;
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: 5px solid #073B4C;
        }

        .filter-section {
            padding: 10px 20px;
            background-color: #E1E8ED;
            text-align: center;
        }

        .action-button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-button:hover {
            background-color: #0056b3;
        }

        .queries-container {
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .single-query {
            border-bottom: 1px solid #ccc;
            padding: 15px;
            color: #333;
        }

        .single-query:last-child {
            border-bottom: none;
        }

        .query-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .query-title {
            font-size: 18px;
            color: #007BFF;
        }

        .query-description {
            color: #666;
            font-size: 14px;
        }

        .query-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            color: #999;
        }

        .status-indicator.answered {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="welcome-section">
        <h1>Welcome to Tech008</h1>
    </div>
    <div class="filter-section">
        <button id="latest-questions">Latest</button>
        <button id="top-questions">Top</button>
        <button id="unanswered-questions">Unanswered</button>
    </div>

    <div class="queries-container" id="query-display"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
    <script>
        var QueryModel = Backbone.Model.extend({});

        var QueriesCollection = Backbone.Collection.extend({
            model: QueryModel,
            url: 'http://localhost/Tech008/index.php/Questions/get_filtered_questions',

            retrieveQueries: function(queryType) {
                this.fetch({
                    data: { filter: queryType },
                    reset: true
                });
            }
        });

        var QueriesView = Backbone.View.extend({
            el: '#query-display',

            initialize: function() {
                this.listenTo(this.collection, 'reset', this.render);
            },

            render: function() {
                this.$el.empty();
                this.collection.forEach(this.addQuery, this);
                return this;
            },

            addQuery: function(query) {
                var authorFullName = query.get('fName') + ' ' + query.get('LName');
                var answeredMarker = '';
                if (query.get('answered') === 1) {
                    answeredMarker = '<span class="status-indicator answered">✔ Answered</span>';
                }

                var queryMarkup = `<div class="single-query">
                    <div class="query-details">
                        <span class="author">Posted by: ${authorFullName}</span>
                        ${answeredMarker}
                    </div>
                    <h2 class="query-title">
                        <a href="http://localhost/Tech008/index.php/questions/question_info/${query.get('question_id')}">${query.get('title')}</a>
                    </h2>
                    <p class="query-description">${query.get('body')}</p>
                    <div class="query-stats">
                        <span class="answers">${query.get('answer_count')} Answers</span>
                        <span class="views">${query.get('views')} Views</span>
                        <span class="votes">${query.get('votes')} Votes</span>
                        <span class="posted-date">Posted on: ${query.get('Date_posted')}</span>
                    </div>
                </div>`;
                this.$el.append(queryMarkup);
            }
        });

        var FilterControls = Backbone.View.extend({
            el: '.filter-section',

            events: {
                'click #latest-questions': function() { this.applyFilter('latest'); },
                'click #top-questions': function() { this.applyFilter('top'); },
                'click #unanswered-questions': function() { this.applyFilter('unanswered'); }
            },

            initialize: function(options) {
                this.queriesView = options.queriesView;
            },

            applyFilter: function(filterType) {
                this.queriesView.collection.retrieveQueries(filterType);
            }
        });

        $(function() {
            var queriesCollection = new QueriesCollection();
            var queriesView = new QueriesView({ collection: queriesCollection });
            var filterControls = new FilterControls({ queriesView: queriesView });

            filterControls.applyFilter('latest');
        });
    </script>
</body>
</html>
