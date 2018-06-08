<?php

    namespace IdnoPlugins\Food {

        class Main extends \Idno\Common\Plugin {

            function registerPages() {
                \Idno\Core\site()->addPageHandler('/food/edit/?', '\IdnoPlugins\Food\Pages\Edit');
                \Idno\Core\site()->addPageHandler('/food/edit/([A-Za-z0-9]+)/?', '\IdnoPlugins\Food\Pages\Edit');
                \Idno\Core\site()->addPageHandler('/food/delete/([A-Za-z0-9]+)/?', '\IdnoPlugins\Food\Pages\Delete');
                \Idno\Core\site()->addPageHandler('/food/([A-Za-z0-9]+)/.*', '\Idno\Pages\Entity\View');
            }

            /**
             * Get the total file usage
             * @param bool $user
             * @return int
             */
            function getFileUsage($user = false) {

                $total = 0;

                if (!empty($user)) {
                    $search = ['user' => $user];
                } else {
                    $search = [];
                }

                if ($foods = food::get($search,[],9999,0)) {
                    foreach($foods as $food) {
                        /* @var food $food */
                        if ($food instanceof food) {
                            if ($attachments = $food->getAttachments()) {
                                foreach($attachments as $attachment) {
                                    $total += $attachment['length'];
                                }
                            }
                        }
                    }
                }

                return $total;
            }

        }

    }
