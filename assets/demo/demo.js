demo = {
  initPickColor: function() {
    $('.pick-class-label').click(function() {
      var new_class = $(this).attr('new-class');
      var old_class = $('#display-buttons').attr('data-class');
      var display_div = $('#display-buttons');
      if (display_div.length) {
        var display_buttons = display_div.find('.btn');
        display_buttons.removeClass(old_class);
        display_buttons.addClass(new_class);
        display_div.attr('data-class', new_class);
      }
    });
  },

  // initDocChart: function() {
  //   chartColor = "#FFFFFF";
  //
  //   ctx = document.getElementById('chartHours').getContext("2d");
  //
  //   myChart = new Chart(ctx, {
  //     type: 'line',
  //
  //     data: {
  //       labels: ["12AM", "1AM", "2AM", "3AM", "4AM", "5AM", "6AM", "7AM", "8AM", "9AM","10AM","11AM","12AM","1PM","2PM","3PM","4PM",],
  //       datasets: [{
  //           borderColor: "#6bd098",
  //           backgroundColor: "#6bd098",
  //           pointRadius: 0,
  //           pointHoverRadius: 0,
  //           borderWidth: 3,
  //           data: [300, 310, 316, 322, 330, 326, 333, 345, 338, 354]
  //         },
  //         {
  //           borderColor: "#f17e5d",
  //           backgroundColor: "#f17e5d",
  //           pointRadius: 0,
  //           pointHoverRadius: 0,
  //           borderWidth: 3,
  //           data: [320, 340, 365, 360, 370, 385, 390, 384, 408, 420]
  //         },
  //         {
  //           borderColor: "#fcc468",
  //           backgroundColor: "#fcc468",
  //           pointRadius: 0,
  //           pointHoverRadius: 0,
  //           borderWidth: 3,
  //           data: [370, 394, 415, 409, 425, 445, 460, 450, 478, 484]
  //         }
  //       ]
  //     },
  //     options: {
  //       legend: {
  //         display: false
  //       },
  //
  //       tooltips: {
  //         enabled: false
  //       },
  //
  //       scales: {
  //         yAxes: [{
  //
  //           ticks: {
  //             fontColor: "#9f9f9f",
  //             beginAtZero: false,
  //             maxTicksLimit: 5,
  //             //padding: 20
  //           },
  //           gridLines: {
  //             drawBorder: false,
  //             zeroLineColor: "#ccc",
  //             color: 'rgba(255,255,255,0.05)'
  //           }
  //
  //         }],
  //
  //         xAxes: [{
  //           barPercentage: 1.6,
  //           gridLines: {
  //             drawBorder: false,
  //             color: 'rgba(255,255,255,0.1)',
  //             zeroLineColor: "transparent",
  //             display: false,
  //           },
  //           ticks: {
  //             padding: 20,
  //             fontColor: "#9f9f9f"
  //           }
  //         }]
  //       },
  //     }
  //   });
  //
  // },

  initChartsPages: function() {
    chartColor = "#FFFFFF";

    ctx = document.getElementById('chartHours').getContext("2d");
    // labels: ["12AM", "1AM", "2AM", "3AM", "4AM", "5AM", "6AM", "7AM", "8AM", "9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM"],
  // $(document).ready(function(){
  //
  //   myChart = new Chart(ctx, {
  //     type: 'line',
  //
  //     data: {
  //       labels: ["12AM", "1AM", "2AM", "3AM", "4AM", "5AM", "6AM", "7AM", "8AM", "9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM"],
  //       // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
  //
  //       datasets: [{
  //           borderColor: "#ef6e84",
  //           backgroundColor: "#ef6e84",
  //           pointRadius: 0,
  //           pointHoverRadius: 0,
  //           label: "Female",
  //           borderWidth: 3,
  //           data: [300, 310, 316, 322, 330, 326, 333, 345,300, 310, 316, 322, 330, 326, 333, 345]
  //
  //         },
  //         {
  //           borderColor: "#824cde",
  //           backgroundColor: "#824cde",
  //           pointRadius: 0,
  //           pointHoverRadius: 0,
  //           borderWidth: 3,
  //           label: "Male",
  //           data: [320, 340, 365, 360, 370, 385, 390, 384,320, 340, 365, 360, 370, 385, 390, 384]
  //         },
  //         // {
  //         //   borderColor: "#fcc468",
  //         //   backgroundColor: "#fcc468",
  //         //   pointRadius: 0,
  //         //   pointHoverRadius: 0,
  //         //   borderWidth: 3,
  //         //   data: [370, 394, 415, 409, 425, 445, 460, 450,370, 394, 415, 409, 425, 445, 460, 450]
  //         // }
  //       ]
  //     },
  //     options: {
  //       legend: {
  //         display: true
  //       },
  //
  //       tooltips: {
  //         enabled: false
  //       },
  //
  //       scales: {
  //         yAxes: [{
  //
  //           ticks: {
  //             fontColor: "#9f9f9f",
  //             beginAtZero: false,
  //             maxTicksLimit: 5,
  //             //padding: 20
  //           },
  //           gridLines: {
  //             drawBorder: false,
  //             zeroLineColor: "#ccc",
  //             color: 'rgba(255,255,255,0.05)'
  //           }
  //
  //         }],
  //
  //         xAxes: [{
  //           barPercentage: 1.6,
  //           gridLines: {
  //             drawBorder: false,
  //             color: 'rgba(255,255,255,0.1)',
  //             zeroLineColor: "transparent",
  //             display: false,
  //           },
  //           ticks: {
  //             padding: 20,
  //             fontColor: "#9f9f9f"
  //           }
  //         }]
  //       },
  //     }
  //   });
  // });
    $(document).ready(function(){
      $.ajax({
        url: "/admin/get_users",
        // url: "/dating/index.php/admin/get_users",
        success: function (response) {
          var res = JSON.parse(response);
          var mhour_12am = res.mhour_12am;
          var mhour_1am = res.mhour_1am;
          var mhour_2am = res.mhour_2am;
          var mhour_3am = res.mhour_3am;
          var mhour_4am = res.mhour_4am;
          var mhour_5am = res.mhour_5am;
          var mhour_6am = res.mhour_6am;
          var mhour_7am = res.mhour_7am;
          var mhour_8am = res.mhour_8am;
          var mhour_9am = res.mhour_9am;
          var mhour_10am = res.mhour_10am;
          var mhour_11am = res.mhour_11am;
          var mhour_12pm = res.mhour_12pm;
          var mhour_1pm = res.mhour_1pm;
          var mhour_2pm = res.mhour_2pm;
          var mhour_3pm = res.mhour_3pm;
          var mhour_4pm = res.mhour_4pm;

          var fhour_12am = res.fhour_12am;
          var fhour_1am = res.fhour_1am;
          var fhour_2am = res.fhour_2am;
          var fhour_3am = res.fhour_3am;
          var fhour_4am = res.fhour_4am;
          var fhour_5am = res.fhour_5am;
          var fhour_6am = res.fhour_6am;
          var fhour_7am = res.fhour_7am;
          var fhour_8am = res.fhour_8am;
          var fhour_9am = res.fhour_9am;
          var fhour_10am = res.fhour_10am;
          var fhour_11am = res.fhour_11am;
          var fhour_12pm = res.fhour_12pm;
          var fhour_1pm = res.fhour_1pm;
          var fhour_2pm = res.fhour_2pm;
          var fhour_3pm = res.fhour_3pm;
          var fhour_4pm = res.fhour_4pm;

          // console.log(nov);
          myChart = new Chart(ctx, {
            type: 'line',

            data: {
              labels: ["12AM", "1AM", "2AM", "3AM", "4AM", "5AM", "6AM", "7AM", "8AM", "9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM"],
              // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],

              datasets: [{
                  borderColor: "#824cde",
                  backgroundColor: "#824cde",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  borderWidth: 3,
                  label: "Male",
                  data: [mhour_12am, mhour_1am, mhour_2am, mhour_3am, mhour_4am, mhour_5am, mhour_6am, mhour_7am, mhour_8am, mhour_9am, mhour_10am, mhour_11am, mhour_12pm, mhour_1pm, mhour_2pm, mhour_3pm, mhour_4pm]
                },
                {
                  borderColor: "#ef6e84",
                  backgroundColor: "#ef6e84",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  label: "Female",
                  borderWidth: 3,
                  data: [fhour_12am, fhour_1am, fhour_2am, fhour_3am, fhour_4am, fhour_5am, fhour_6am, fhour_7am, fhour_8am, fhour_9am, fhour_10am, fhour_11am, fhour_12pm, fhour_1pm, fhour_2pm, fhour_3pm, fhour_4pm]
                }
              ]
            },
            options: {
              legend: {
                display: true
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    fontColor: "#9f9f9f",
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    //padding: 20
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "#ccc",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent",
                    display: false,
                  },
                  ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f"
                  }
                }]
              },
            }
          });

        }
      });
    });

    ctx2 = document.getElementById('chartHours_weekly').getContext("2d");

    $(document).ready(function(){
      $.ajax({
        url: "/admin/get_users_weekly",
        // url: "/dating/index.php/admin/get_users_weekly",
        success: function (response) {
          var res = JSON.parse(response);
          var mMonday = res.mMonday;
          var mTuesday = res.mTuesday;
          var mWednesday = res.mWednesday;
          var mThursday = res.mThursday;
          var mFriday = res.mFriday;
          var mSaturday = res.mSaturday;
          var mSunday = res.mSunday;

          var fMonday = res.fMonday;
          var fTuesday = res.fTuesday;
          var fWednesday = res.fWednesday;
          var fThursday = res.fThursday;
          var fFriday = res.fFriday;
          var fSaturday = res.fSaturday;
          var fSunday = res.fSunday;
          // console.log(nov);
          myChart = new Chart(ctx2, {
            type: 'line',

            data: {
              labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
              // labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],

              datasets: [{
                  borderColor: "#824cde",
                  backgroundColor: "#824cde",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  borderWidth: 3,
                  label: "Male",
                  data: [mMonday, mTuesday, mWednesday, mThursday, mFriday, mSaturday, mSunday]
                },
                {
                  borderColor: "#ef6e84",
                  backgroundColor: "#ef6e84",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  label: "Female",
                  borderWidth: 3,
                  data: [fMonday, fTuesday, fWednesday, fThursday, fFriday, fSaturday, fSunday]
                }
              ]
            },
            options: {
              legend: {
                display: true
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    fontColor: "#9f9f9f",
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    //padding: 20
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "#ccc",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent",
                    display: false,
                  },
                  ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f"
                  }
                }]
              },
            }
          });

        }
      });
    });

    ctx3 = document.getElementById('chartHours_monthly').getContext("2d");
    // labels: ["12AM", "1AM", "2AM", "3AM", "4AM", "5AM", "6AM", "7AM", "8AM", "9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM"],

    $(document).ready(function(){
      $.ajax({
        url: "/admin/get_users_monthly",
        // url: "/dating/index.php/admin/get_users_monthly",
        success: function (response) {
          var res = JSON.parse(response);
          var mJanuary = res.mJanuary;
          var mFebruary = res.mFebruary;
          var mMarch = res.mMarch;
          var mApril = res.mApril;
          var mMay = res.mMay;
          var mJune = res.mJune;
          var mJuly = res.mJuly;
          var mAugust = res.mAugust;
          var mSeptember = res.mSeptember;
          var mOctober = res.mOctober;
          var mNovember = res.mNovember;
          var mDecember = res.mDecember;

          var fJanuary = res.fJanuary;
          var fFebruary = res.fFebruary;
          var fMarch = res.fMarch;
          var fApril = res.fApril;
          var fMay = res.fMay;
          var fJune = res.fJune;
          var fJuly = res.fJuly;
          var fAugust = res.fAugust;
          var fSeptember = res.fSeptember;
          var fOctober = res.fOctober;
          var fNovember = res.fNovember;
          var fDecember = res.fDecember;
          // console.log(mFebruary);
          myChart = new Chart(ctx3, {
            type: 'line',

            data: {
              // labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
              labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],

              datasets: [{
                  borderColor: "#824cde",
                  backgroundColor: "#824cde",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  borderWidth: 3,
                  label: "Male",
                  data: [mJanuary, mFebruary, mMarch, mApril, mMay, mJune, mJuly, mAugust, mSeptember, mOctober, mNovember, mDecember]
                },
                {
                  borderColor: "#ef6e84",
                  backgroundColor: "#ef6e84",
                  pointRadius: 0,
                  pointHoverRadius: 0,
                  label: "Female",
                  borderWidth: 3,
                  data: [fJanuary, fFebruary, fMarch, fApril, fMay, fJune, fJuly, fAugust, fSeptember, fOctober, fNovember, fDecember]
                }
              ]
            },
            options: {
              legend: {
                display: true
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    fontColor: "#9f9f9f",
                    beginAtZero: false,
                    maxTicksLimit: 5,
                    //padding: 20
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "#ccc",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent",
                    display: false,
                  },
                  ticks: {
                    padding: 20,
                    fontColor: "#9f9f9f"
                  }
                }]
              },
            }
          });

        }
      });
    });



    ctx = document.getElementById('chartEmail').getContext("2d");

    myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: [1, 2, 3],
        datasets: [{
          label: "Emails",
          pointRadius: 0,
          pointHoverRadius: 0,
          backgroundColor: [
            '#4acccd',
            '#fcc468',
            '#ef8157'
          ],
          borderWidth: 0,
          data: [750, 500, 250]
        }]
      },

      options: {

        legend: {
          display: false
        },

        pieceLabel: {
          render: 'percentage',
          fontColor: ['white'],
          precision: 2
        },

        tooltips: {
          enabled: false
        },

        scales: {
          yAxes: [{

            ticks: {
              display: false
            },
            gridLines: {
              drawBorder: false,
              zeroLineColor: "transparent",
              color: 'rgba(255,255,255,0.05)'
            }

          }],

          xAxes: [{
            barPercentage: 1.6,
            gridLines: {
              drawBorder: false,
              color: 'rgba(255,255,255,0.1)',
              zeroLineColor: "transparent"
            },
            ticks: {
              display: false,
            }
          }]
        },
      }
    });

    var speedCanvasCompany = document.getElementById("speedChartCompany");

    var dataFirst = {
      data: [0, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 70],
      fill: false,
      borderColor: '#fbc658',
      backgroundColor: 'transparent',
      pointBorderColor: '#fbc658',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var dataSecond = {
      data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
      fill: false,
      borderColor: '#51CACF',
      backgroundColor: 'transparent',
      pointBorderColor: '#51CACF',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8
    };

    var speedData = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [dataFirst, dataSecond]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvasCompany, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });

    var speedCanvas = document.getElementById("speedChart");

    var dataFirst = {
      data: [0, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 70],
      fill: false,
      borderColor: '#fbc658',
      backgroundColor: 'transparent',
      pointBorderColor: '#fbc658',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var dataSecond = {
      data: [0, 5, 10, 12, 20, 27, 30, 34, 42, 45, 55, 63],
      fill: false,
      borderColor: '#51CACF',
      backgroundColor: 'transparent',
      pointBorderColor: '#51CACF',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8
    };

    var speedData = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [dataFirst, dataSecond]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });
  },

  initGoogleMaps: function() {
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 13,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      styles: [{
        "featureType": "water",
        "stylers": [{
          "saturation": 43
        }, {
          "lightness": -11
        }, {
          "hue": "#0088ff"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "hue": "#ff0000"
        }, {
          "saturation": -100
        }, {
          "lightness": 99
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#808080"
        }, {
          "lightness": 54
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ece2d9"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ccdca1"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#767676"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "poi",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#b8cb93"
        }]
      }, {
        "featureType": "poi.park",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.sports_complex",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.medical",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "simplified"
        }]
      }]

    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Hello World!"
    });

    // To add the marker to the map, call setMap();
    marker.setMap(map);
  },

  showNotification: function(from, align) {
    color = 'primary';

    $.notify({
      icon: "nc-icon nc-bell-55",
      message: "Welcome to <b>Paper Dashboard</b> - a beautiful bootstrap dashboard for every web developer."

    }, {
      type: color,
      timer: 8000,
      placement: {
        from: from,
        align: align
      }
    });
  }

};
